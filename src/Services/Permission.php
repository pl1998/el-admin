<?php

declare(strict_types=1);


namespace ElAdmin\LaravelVueAdmin\Services;

use ElAdmin\LaravelVueAdmin\Models\AdminRole;
use ElAdmin\LaravelVueAdmin\Models\AdminRoleMenus;
use ElAdmin\LaravelVueAdmin\Models\AdminUserRoles;

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
