<?php

declare(strict_types=1);


namespace Latent\ElAdmin\Services;

use Latent\ElAdmin\Enum\ModelEnum;
use Latent\ElAdmin\Models\AdminMenu;
use Latent\ElAdmin\Models\AdminRoleMenu;
use Latent\ElAdmin\Models\AdminUserRoles;
use Latent\ElAdmin\Models\MenusCache;
use Psr\SimpleCache\InvalidArgumentException;

trait Permission
{
    /**
     * @return array|null
     */
    public function getAllRoles(): ?array
    {
        return AdminUserRoles::query()
            ->where('user_id',auth(config('el_admin.guard'))->user()->id ?? 0)
            ->pluck('role_id')?->toArray();
    }
    /**
     * Get all menus
     * @return array
     * @throws InvalidArgumentException
     */
    public function getUserMenus() :array
    {
        $userId= auth( config('el_admin.guard'))->user()->id ?? 0;

        if( $data = MenusCache::getCache()->get(MenusCache::getPrefix($userId))) {
            return $data;
        }
        if(auth(config('el_admin.guard'))->user()->name ?? '' == 'admin') {
            $menes =  AdminMenu::query()->where('hidden',ModelEnum::NORMAL)->get()?->toArray();
        }else{
            $menes = [];
            AdminRoleMenu::with('menus')
                ->where('role_id',$this->getAllRoles())
                ->get()
                ->map(function ($items) use(&$menes) {
                    if(!empty($items->menus)) {
                        foreach ($items->menus as $item) {
                            $menes[] = $item?->toArray();
                        }
                    }
                });
        }

        MenusCache::setCache($userId,$menes);

        return $menes;
    }

    /**
     * Get all menus or nodes
     * @return array
     * @throws InvalidArgumentException
     */
    public function getUserMenusAndNode() :array
    {
        $list = $this->getUserMenus();

        return [
          collect($list)->where('type',ModelEnum::MENU)?->toArray(),
          collect($list)->where('type',ModelEnum::API)?->toArray(),
        ];

    }

    /**
     * check permission
     * @param string $path
     * @param string $method
     * @return bool
     * @throws InvalidArgumentException
     */
    public function checkApiPermission(string $path,string $method) :bool
    {
        $menes = $this->getUserMenus();

        if(empty($menes)) return false;

        if( collect($menes)
            ->where('type',ModelEnum::API)
            ->where('path',$path)
            ->where('method',$method)
            ->isEmpty()) return false;

        return true;
    }
}
