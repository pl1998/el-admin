<?php

declare(strict_types=1);


namespace Latent\ElAdmin\Services;

use Latent\ElAdmin\Models\AdminRoleMenus;
use Latent\ElAdmin\Models\AdminUserRoles;

trait Permission
{
    /**
     * @return mixed[]|null
     */
    public function getAllRoles()
    {
        return AdminUserRoles::query()
            ->where('user_id',auth(config('el_admin.guard'))->id)
            ->pluck('role_id')?->toArray();
    }
    /**
     * Get all menus
     * @return array
     */
    public function getAllUserMenus() :array
    {
        $menes = [];
        AdminRoleMenus::with('menus')
            ->where('role_id',$this->getAllRoles())
            ->get()
            ->map(function ($items) use(&$menes) {
                if(!empty($items->menus)) {
                    foreach ($items->menus as $item) {
                        $menes[] = $item?->toArray();
                    }
                }
            });
        return $menes;
    }
    /**
     * check permission
     * @param string $path
     * @param string $method
     * @return bool
     */
    public function checkApiPermission(string $path,string $method) :bool
    {
        $menes = $this->getAllUserMenus();
        if(empty($menes)) return false;
        if( collect($menes)->where('path',$path)
            ->where('method',$method)
            ->isEmpty()) return false;

        return true;
    }
}
