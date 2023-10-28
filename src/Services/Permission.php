<?php

declare(strict_types=1);

/*
 * This file is part of the latent/el-admin.
 *
 * (c) latent<pltrueover@gmail.com>
 *
 * This source file is subject to the MIT license that is bundled
 * with this source code in the file LICENSE.
 */

namespace Latent\ElAdmin\Services;

use Illuminate\Support\Arr;
use Latent\ElAdmin\Enum\MethodEnum;
use Latent\ElAdmin\Enum\ModelEnum;
use Latent\ElAdmin\Models\MenusCache;
use Latent\ElAdmin\Models\ModelTraits;
use Psr\SimpleCache\InvalidArgumentException;

trait Permission
{
    use ModelTraits;

    /**
     * Request params.
     */
    public array  $params = [];

    /**
     * Get users all roles.
     *
     * @throws \Illuminate\Contracts\Container\BindingResolutionException
     */
    public function getAllRoles(): ?array
    {
        return $this->getUserRolesModel()
            ->where('user_id', auth(config('el_admin.guard'))->user()->id ?? 0)
            ->pluck('role_id')?->toArray();
    }

    /**
     * Get users all menus.
     *
     * @throws InvalidArgumentException
     */
    public function getUserMenus(): array
    {
        $userId = auth(config('el_admin.guard'))->user()->id ?? 0;

        if ($data = MenusCache::getCache()->get(MenusCache::getPrefix($userId))) {
            return $data;
        }
        $menes = $this->getRoleMenus($this->getAllRoles());

        MenusCache::setCache($userId, $menes);

        return $menes;
    }

    /**
     * Get users all menus.
     *
     * @throws InvalidArgumentException
     */
    public function getUserAllPermission(): array
    {
        $userId = auth(config('el_admin.guard'))->user()->id ?? 0;

        if ($data = MenusCache::getCache()->get(MenusCache::getPrefix($userId))) {
            return $data;
        }
        $menes = $this->getRoleMenus($this->getAllRoles());

        MenusCache::setCache($userId, $menes);

        return $menes;
    }

    /**
     * Get all menus or nodes.
     *
     * @throws InvalidArgumentException
     */
    public function getUserMenusAndNode(): array
    {
        $list = $this->getUserMenus();

        return [
            collect($list)->where('type', ModelEnum::MENU)?->toArray(),
            collect($list)->where('type', ModelEnum::API)?->toArray(),
        ];
    }

    /**
     * @return array|null
     *
     * @throws InvalidArgumentException
     */
    public function getUserRoutes(array $params): array
    {
        $this->params = $params;
        $list = $this->getUserMenus();

        return collect($list)
            ->where('type', $this->params['type'])
            ->map(function ($menu) {
                if (! empty($this->params['route']) && ModelEnum::API == $this->params['route']) {
                    $data = [
                        'meta' => [
                            'title' => $menu['name'],
                            'icon' => $menu['icon'],
                        ],
                        'type' => $menu['type'],
                        'path' => $menu['route_path'],
                        'component' => $menu['component'],
                        'name' => $menu['route_name'],
                        'parent_id' => $menu['parent_id'],
                        'id' => $menu['id'],
                    ];
                    if (0 == $menu['parent_id']) {
                        unset($data['component'],$data['name'],$data['path']);
                    }
                } else {
                    return Arr::only($menu, ['type', 'id', 'name', 'icon', 'parent_id']);
                }

                return $data;
            })?->toArray();
    }

    /**
     * get role menus.
     *
     * @throws \Illuminate\Contracts\Container\BindingResolutionException
     */
    public function getRoleMenus(array $roleId = []): array
    {
        if (empty($roleId)) {
            return [];
        }
        $menus = [];
        $this->getRoleModel()
            ->whereIn('id', $roleId)
            ->with('menus')
            ->get()
            ->map(function ($roles) use (&$menus) {
                $data = $roles->toArray();
                collect($data['menus'])->map(function ($item) use (&$menus) {
                    $menus[] = $item;
                })?->toArray();
            })?->toArray();

        return $menus;
    }

    /**
     * check permission.
     *
     * @throws InvalidArgumentException
     */
    public function checkApiPermission(string $path, string $method, string $routeName): bool
    {
        $menes = $this->getUserMenus();

        if (empty($menes)) {
            return false;
        }
        if ($this->isCheck($menes, $method, 'route_path', $path)) {
            return true;
        }
        if ($this->isCheck($menes, $method, 'route_name', $routeName)) {
            return true;
        }

        return false;
    }

    /**
     * check permission.
     */
    protected function isCheck(array $menes, string $method, string $key, string $value): bool
    {
        return collect($menes)
            ->where('type', ModelEnum::API)
            ->where($key, $value)
            ->where('method', MethodEnum::METHOD[strtolower($method)] ?? 1)
            ->isEmpty() ? false : true;
    }
}
