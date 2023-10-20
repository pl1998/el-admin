<?php

namespace Latent\ElAdmin\Models;

use Illuminate\Database\Seeder;
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

        // create permission
        AdminMenu::truncate();
        AdminMenu::insert([
            [
                'parent_id' => 0,
                'name' => '演示',
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
            'name' => '多级导航',
            'icon' => 'sidebar-menu ',
            'route_name' => 'multilevelMenuExample',
            'route_path' => '/multilevel_menu_example',
            'component' => 'Layout',
            'sort' => 0,
            'type' => ModelEnum::MENU,
            'created_at' => $created,
            'updated_at' => $created,
            ],
            [
                'parent_id' => 2,
                'name' => '导航1',
                'icon' => 'sidebar-menu ',
                'route_name' => 'multilevelMenuExample1',
                'route_path' => 'page',
                'component' => 'multilevel_menu_example/page.vue',
                'sort' => 0,
                'type' => ModelEnum::MENU,
                'created_at' => $created,
                'updated_at' => $created,
            ],
            [
                'parent_id' => 2,
                'name' => '导航2',
                'icon' => 'sidebar-menu ',
                'route_name' => 'multilevelMenuExample2',
                'route_path' => 'level2',
                'component' => '/multilevel_menu_example/level2/page',
                'sort' => 0,
                'type' => ModelEnum::MENU,
                'created_at' => $created,
                'updated_at' => $created,
            ],
            [
                'parent_id' => 4,
                'name' => '导航2-1',
                'icon' => 'sidebar-menu',
                'route_name' => 'multilevelMenuExample2-1',
                'route_path' => 'page',
                'component' => 'multilevel_menu_example/level2/page.vue',
                'sort' => 0,
                'type' => ModelEnum::MENU,
                'created_at' => $created,
                'updated_at' => $created,
            ]
//            [
//                'parent_id' => 0,
//                'name' => '系统管理',
//                'icon' => 'fa fa-pencil-square',
//                'route_name' => 'admin',
//                'route_path' => '/admin',
//                'component' => '',
//                'sort' => 0,
//                'type' => ModelEnum::MENU,
//                'created_at' => $created,
//                'updated_at' => $created,
//            ],
//            [
//                'parent_id' => 1,
//                'name' => '权限管理',
//                'icon' => 'fa fa-steam-square',
//                'route_name' => 'permission',
//                'route_path' => '/permission',
//                'component' => '',
//                'sort' => 0,
//                'type' => ModelEnum::MENU,
//                'created_at' => $created,
//                'updated_at' => $created,
//            ],
//            [
//                'parent_id' => 1,
//                'name' => '角色管理',
//                'icon' => 'fa fa-user-secret',
//                'route_name' => 'role',
//                'route_path' => '/role',
//                'component' => '',
//                'sort' => 0,
//                'type' => ModelEnum::MENU,
//                'created_at' => $created,
//                'updated_at' => $created,
//            ],
//            [
//                'parent_id' => 1,
//                'name' => '用户管理',
//                'icon' => 'fa fa-users',
//                'route_name' => 'user',
//                'route_path' => '/user',
//                'component' => '',
//                'sort' => 0,
//                'type' => ModelEnum::MENU,
//                'created_at' => $created,
//                'updated_at' => $created,
//            ],
//            [
//                'parent_id' => 1,
//                'name' => '用户管理',
//                'icon' => 'fa fa-location-arrow',
//                'route_name' => 'log',
//                'route_path' => '/log',
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
