<?php

declare(strict_types=1);

namespace Latent\ElAdmin\Services;

use Latent\ElAdmin\Enum\ModelEnum;
use Latent\ElAdmin\Models\GetModelTraits;
use Latent\ElAdmin\Models\MenusCache;
use Psr\SimpleCache\InvalidArgumentException;

trait Permission
{
    use GetModelTraits;

    public function getAllRoles(): ?array
    {
        return $this->getUserRolesModel()
            ->where('user_id', auth(config('el_admin.guard'))->user()->id ?? 0)
            ->pluck('role_id')?->toArray();
    }

    /**
     * Get all menus.
     *
     * @throws InvalidArgumentException
     */
    public function getUserMenus(): array
    {
        $userId = auth(config('el_admin.guard'))->user()->id ?? 0;

        if ($data = MenusCache::getCache()->get(MenusCache::getPrefix($userId))) {
            return $data;
        }
        if (auth(config('el_admin.guard'))->user()->name ?? '' == 'admin') {
            $menes = $this->getMenusModel()->where('hidden', ModelEnum::NORMAL)->get()?->toArray();
        } else {
            $menes = $this->getRoleMenus($this->getAllRoles());
        }
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
     * @throws InvalidArgumentException
     */
    public function getUserRoutes() :array
    {
        $list = $this->getUserMenus();
        return   collect($list)->where('type', ModelEnum::MENU)->map(function ($menu){
            return [
                'meta' => [
                    'title' => $menu->name,
                    'icon'  => $menu->icon,
                ],
                'path'      => $menu->route_path,
                'component' => $menu->component,
                'redirect'  => '/',
                'name'      => $menu->route_name,
                'parent_id' => $menu->parent_id,
                'id'        => $menu->id
            ];
        })?->toArray();
    }

    public function getRoleMenus(array $roleId): array
    {
        $menes = [];
        $this->getRoleMenusModel()
            ->with('menus')
            ->where('role_id', $roleId)
            ->get([''])
            ->map(function ($items) use (&$menes) {
                if (!empty($items->menus)) {
                    foreach ($items->menus as $item) {
                        $menes[] = $item?->toArray();
                    }
                }
            });

        return $menes;
    }

    /**
     * check permission.
     *
     * @throws InvalidArgumentException
     */
    public function checkApiPermission(string $path, string $method): bool
    {
        $menes = $this->getUserMenus();

        if (empty($menes)) {
            return false;
        }

        if (collect($menes)
            ->where('type', ModelEnum::API)
            ->where('path', $path)
            ->where('method', $method)
            ->isEmpty()) {
            return false;
        }

        return true;
    }
}
