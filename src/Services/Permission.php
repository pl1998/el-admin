<?php

declare(strict_types=1);


namespace Latent\ElAdmin\Services;

use Latent\ElAdmin\Models\AdminRole;
use Latent\ElAdmin\Models\AdminRoleMenus;
use Latent\ElAdmin\Models\AdminUserRoles;

trait Permission
{
    public function getAllRole()
    {
        return AdminUserRoles::query()->where('user_id',user()->id)->pluck('role_id')?->toArray() ;
    }
    public function checkApiPermission(string $path,string $method)
    {
        $allMenus = AdminRoleMenus::with('menus')->where('role_id',$this->getAllRole())
            ->get();

    }
}
