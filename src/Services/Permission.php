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

    /** @var array  */
    public array  $params = [];

    /**
     * Get users all roles
     * @return array|null
     */
    public function getAllRoles(): ?array
    {
        return $this->getUserRolesModel()
            ->where('user_id', auth(config('el_admin.guard'))->user()->id ?? 0)
            ->pluck('role_id')?->toArray();
    }

    /**
     * Get users all menus.
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
     * @param array $params
     * @return array|null
     * @throws InvalidArgumentException
     */
    public function getUserRoutes( array $params) :array
    {
        $this->params = $params;
        $list = $this->getUserMenus();

        return   collect($list)
            ->when(!empty($this->params['type']),function ($q){
              $q->where('type', $this->params['type']);
            })->map(function ($menu){
            if(!empty($this->params['route']) && $this->params['route'] == ModelEnum::API) {
                $data =  [
                    'meta' => [
                        'title' => $menu['name'],
                        'icon'  => $menu['icon'],
                    ],
                    'path'      => $menu['route_path'],
                    'component' => $menu['component'],
                    'name'      => $menu['route_name'],
                    'parent_id' => $menu['parent_id'],
                    'id'        => $menu['id'],
                ];
                if($menu['parent_id'] ==0) {
                    unset($data['redirect']);
                    unset($data['component']);
                    unset($data['name']);
                    unset($data['path']);
                }
            }else {
                return [
                    'parent_id' => $menu['parent_id'],
                    'id'        => $menu['id'],
                    'name'      => $menu['name'],
                    'icon'      => $menu['icon'],
                ];
            }
            return $data;
        })?->toArray();
    }

    /**
     * get role menus
     * @param array $roleId
     * @return array
     */
    public function getRoleMenus(array $roleId = []): array
    {
        if(empty($roleId)) {
            return [];
        }
        $menus = [];
        $this->getRoleModel()
            ->whereIn('id',$roleId)
            ->with('menus')
            ->get()
            ->map(function ($roles) use(&$menus){
                $data = $roles->toArray();
                collect($data['menus'])->map(function ($item) use(&$menus){
                        $menus[]=$item;
                    })?->toArray();
            })?->toArray();
        return $menus;
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
