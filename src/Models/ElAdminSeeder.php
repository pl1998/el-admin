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
        $created = date('Y-m-d H:i:s');
        //create users
        AdminUser::truncate();
        AdminUser::create([
            'name' => 'Administrator',
            'password' => Hash::make('123456'),
            'email'   => 'admin@gamil.com'
        ]);

        // create role
        AdminRole::truncate();
        AdminRole::create([
           'name' => 'Administrator',
            'created_at' => $created
        ]);

        // create permission
        AdminMenu::truncate();
        AdminMenu::install([
            [
                'parent_id' => 0,
                'name'      => '系统管理',
                'icon'      => '',
                'route_name'     => '',
                'route_path'     => '/admin',
                'component'      => '',
                'sort'           => '',
                'type'           => ModelEnum::MENU,
            ],
            [
                'parent_id' => 1,
                'name'      => '权限管理',
                'icon'      => '',
                'route_name'     => '',
                'route_path'     => '/permission',
                'component'      => '',
                'sort'           => '',
                'type'           => ModelEnum::MENU,
            ],
            [
                'parent_id' => 1,
                'name'      => '角色管理',
                'icon'      => '',
                'route_name'     => '',
                'route_path'     => '/role',
                'component'      => '',
                'sort'           => '',
                'type'           => ModelEnum::MENU,
            ],
            [
                'parent_id' => 1,
                'name'      => '用户管理',
                'icon'      => '',
                'route_name'     => '',
                'route_path'     => '/user',
                'component'      => '',
                'sort'           => '',
                'type'           => ModelEnum::MENU,
            ]
        ]);
    }
}
