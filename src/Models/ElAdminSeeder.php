<?php

namespace Latent\ElAdmin\Models;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Artisan;
use Illuminate\Support\Facades\Hash;
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
        if(env('APP_ENV') != 'local') return;

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
                'created_at' => $created,
                'updated_at' => $created,
            ],
//            [
//                'parent_id' => 0,
//                'name' => '演示',
//                'icon' => 'sidebar-default',
//                'route_name' => '',
//                'route_path' => '/',
//                'component' => '',
//                'sort' => 0,
//                'type' => ModelEnum::MENU,
//                'created_at' => $created,
//                'updated_at' => $created,
//            ],

        ]);
        // create permission
        AdminLog::truncate();
    }
}
