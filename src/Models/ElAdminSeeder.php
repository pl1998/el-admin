<?php

/*
 * This file is part of the latent/el-admin.
 *
 * (c) latent<pltrueover@gmail.com>
 *
 * This source file is subject to the MIT license that is bundled
 * with this source code in the file LICENSE.
 */

namespace Latent\ElAdmin\Models;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Artisan;
use Illuminate\Support\Facades\Hash;
use Latent\ElAdmin\Enum\MethodEnum;
use Latent\ElAdmin\Enum\ModelEnum;

class ElAdminSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        if ('local' != env('APP_ENV')) {
            return;
        }

        $created = date('Y-m-d H:i:s');
        // create users
        AdminUser::truncate();
        AdminUser::create([
            'name' => 'Administrator',
            'password' => Hash::make('123456'),
            'email' => 'admin@gmail.com',
            'created_at' => $created,
        ]);

        // create role
        AdminRole::truncate();
        AdminRole::create([
            'name' => 'Administrator',
            'created_at' => $created,
        ]);
        AdminUserRole::truncate();
        AdminUserRole::create([
            'role_id' => 1,
            'user_id' => 1,
        ]);
        Artisan::call('el-admin:clear 0');
        // create permission
        AdminMenu::truncate();
        AdminMenu::insert([
            [
                'parent_id' => 0,
                'name' => '系统',
                'icon' => 'sidebar-default',
                'route_name' => '',
                'route_path' => '/',
                'component' => '',
                'sort' => 0,
                'type' => ModelEnum::MENU,
                'method' => MethodEnum::METHOD[MethodEnum::GET],
                'created_at' => $created,
                'updated_at' => $created,
            ],
            [
                'parent_id' => 1,
                'name' => '权限管理',
                'icon' => 'ep:expand',
                'route_name' => 'Admin',
                'route_path' => '/admin',
                'component' => 'Layout',
                'sort' => 0,
                'type' => ModelEnum::MENU,
                'method' => MethodEnum::METHOD[MethodEnum::GET],
                'created_at' => $created,
                'updated_at' => $created,
            ],
            [
                'parent_id' => 2,
                'name' => '用户',
                'icon' => 'ep:avatar',
                'route_name' => 'adminUser',
                'route_path' => 'user',
                'component' => 'admin/user.vue',
                'sort' => 0,
                'type' => ModelEnum::MENU,
                'method' => MethodEnum::METHOD[MethodEnum::GET],
                'created_at' => $created,
                'updated_at' => $created,
            ],
            [
                'parent_id' => 2,
                'name' => '角色',
                'icon' => 'ep:user-filled',
                'route_name' => 'adminRole',
                'route_path' => 'role',
                'component' => 'admin/role.vue',
                'sort' => 0,
                'type' => ModelEnum::MENU,
                'method' => MethodEnum::METHOD[MethodEnum::GET],
                'created_at' => $created,
                'updated_at' => $created,
            ],
            [
                'parent_id' => 2,
                'name' => '菜单',
                'icon' => 'ep:menu',
                'route_name' => 'adminMenu',
                'route_path' => 'menu',
                'component' => 'admin/menu.vue',
                'sort' => 0,
                'type' => ModelEnum::MENU,
                'method' => MethodEnum::METHOD[MethodEnum::GET],
                'created_at' => $created,
                'updated_at' => $created,
            ],
            [
                'parent_id' => 2,
                'name' => '日志',
                'icon' => 'ep:hide',
                'route_name' => 'adminLog',
                'route_path' => 'log',
                'component' => 'admin/log.vue',
                'sort' => 0,
                'type' => ModelEnum::MENU,
                'method' => MethodEnum::METHOD[MethodEnum::GET],
                'created_at' => $created,
                'updated_at' => $created,
            ],
            [
                'parent_id' => 2,
                'name' => '系统',
                'icon' => 'ep:setting',
                'route_name' => 'adminSystem',
                'route_path' => 'system',
                'component' => 'admin/system.vue',
                'sort' => 0,
                'type' => ModelEnum::MENU,
                'method' => MethodEnum::METHOD[MethodEnum::GET],
                'created_at' => $created,
                'updated_at' => $created,
            ],
            // 用户api
            [
                'parent_id' => 3,
                'name' => '用户列表',
                'icon' => '',
                'route_name' => 'user.index',
                'route_path' => 'api/v1/el_admin/user',
                'component' => '',
                'sort' => 0,
                'method' => MethodEnum::METHOD[MethodEnum::GET],
                'type' => ModelEnum::API,
                'created_at' => $created,
                'updated_at' => $created,
            ],
            [
                'parent_id' => 3,
                'name' => '添加用户',
                'icon' => '',
                'route_name' => 'user.store',
                'route_path' => 'api/v1/el_admin/user',
                'component' => '',
                'sort' => 0,
                'method' => MethodEnum::METHOD[MethodEnum::POST],
                'type' => ModelEnum::API,
                'created_at' => $created,
                'updated_at' => $created,
            ],
            [
                'parent_id' => 3,
                'name' => '更新用户',
                'icon' => '',
                'route_name' => 'user.update',
                'route_path' => 'api/v1/el_admin/user/{user}',
                'component' => '',
                'sort' => 0,
                'method' => MethodEnum::METHOD[MethodEnum::PUT],
                'type' => ModelEnum::API,
                'created_at' => $created,
                'updated_at' => $created,
            ],

            // 角色api
            [
                'parent_id' => 4,
                'name' => '角色列表',
                'icon' => '',
                'route_name' => 'role.index',
                'route_path' => 'api/v1/el_admin/role',
                'component' => '',
                'sort' => 0,
                'method' => MethodEnum::METHOD[MethodEnum::GET],
                'type' => ModelEnum::API,
                'created_at' => $created,
                'updated_at' => $created,
            ],
            [
                'parent_id' => 4,
                'name' => '添加角色',
                'icon' => '',
                'route_name' => 'role.store',
                'route_path' => 'api/v1/el_admin/role',
                'component' => '',
                'sort' => 0,
                'method' => MethodEnum::METHOD[MethodEnum::POST],
                'type' => ModelEnum::API,
                'created_at' => $created,
                'updated_at' => $created,
            ],
            [
                'parent_id' => 4,
                'name' => '更新角色',
                'icon' => '',
                'route_name' => 'role.update',
                'route_path' => 'api/v1/el_admin/role/{role}',
                'component' => '',
                'sort' => 0,
                'method' => MethodEnum::METHOD[MethodEnum::PUT],
                'type' => ModelEnum::API,
                'created_at' => $created,
                'updated_at' => $created,
            ],
            // 菜单api
            [
                'parent_id' => 5,
                'name' => '菜单列表',
                'icon' => '',
                'route_name' => 'menu.index',
                'route_path' => 'api/v1/el_admin/menu',
                'component' => '',
                'sort' => 0,
                'method' => MethodEnum::METHOD[MethodEnum::GET],
                'type' => ModelEnum::API,
                'created_at' => $created,
                'updated_at' => $created,
            ],
            [
                'parent_id' => 5,
                'name' => '添加菜单',
                'icon' => '',
                'route_name' => 'menu.store',
                'route_path' => 'api/v1/el_admin/menu',
                'component' => '',
                'sort' => 0,
                'method' => MethodEnum::METHOD[MethodEnum::POST],
                'type' => ModelEnum::API,
                'created_at' => $created,
                'updated_at' => $created,
            ],
            [
                'parent_id' => 5,
                'name' => '更新菜单',
                'icon' => '',
                'route_name' => 'menu.update',
                'route_path' => 'api/v1/el_admin/menu/{menu}',
                'component' => '',
                'sort' => 0,
                'method' => MethodEnum::METHOD[MethodEnum::PUT],
                'type' => ModelEnum::API,
                'created_at' => $created,
                'updated_at' => $created,
            ],
            [
                'parent_id' => 5,
                'name' => '删除菜单',
                'icon' => '',
                'route_name' => 'menu.destroy',
                'route_path' => 'api/v1/el_admin/menu/{menu}',
                'component' => '',
                'sort' => 0,
                'method' => MethodEnum::METHOD[MethodEnum::DELETE],
                'type' => ModelEnum::API,
                'created_at' => $created,
                'updated_at' => $created,
            ],
            // 日志api
            [
                'parent_id' => 6,
                'name' => '日志列表',
                'icon' => '',
                'route_name' => 'log.index',
                'route_path' => 'api/v1/el_admin/log',
                'component' => '',
                'sort' => 0,
                'method' => MethodEnum::METHOD[MethodEnum::GET],
                'type' => ModelEnum::API,
                'created_at' => $created,
                'updated_at' => $created,
            ],
            [
                'parent_id' => 6,
                'name' => '删除日志',
                'icon' => '',
                'route_name' => 'user.destroy',
                'route_path' => 'api/v1/el_admin/log/{log}',
                'component' => '',
                'sort' => 0,
                'method' => MethodEnum::METHOD[MethodEnum::DELETE],
                'type' => ModelEnum::API,
                'created_at' => $created,
                'updated_at' => $created,
            ],
        ]);
        // create permission
        AdminLog::truncate();

        AdminRoleMenu::truncate();
        $addMenus = [];

        AdminMenu::query()->pluck('id')
            ->map(function ($id) use (&$addMenus) {
                $addMenus[] = [
                    'role_id' => 1,
                    'menu_id' => $id,
                ];
            });
        AdminRoleMenu::query()->insert($addMenus);
    }
}
