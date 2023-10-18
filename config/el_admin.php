<?php

return [

    /*
    |--------------------------------------------------------------------------
    | el-admin logo
    |--------------------------------------------------------------------------
    |
    */
    'logo'  => 'logo.png',

    /*
   |--------------------------------------------------------------------------
   | el-admin jwt guard
   |--------------------------------------------------------------------------
   |
   */

    'guard' => 'admin',
    /*
     |--------------------------------------------------------------------------
     | el-admin  prem middleware
     |--------------------------------------------------------------------------
     |
     | el-admin Related http middleware
     |
     */
    'middleware' => [
        // el-admin http middleware for permission control verification
        'rbac' => Latent\ElAdmin\Middleware\RbacMiddleware::class,
    ],

    /*
    |--------------------------------------------------------------------------
    | el-admin database settings
    |--------------------------------------------------------------------------
    |
    | Here are database settings for el-admin builtin model & tables.
    |
    */
    'database' => [
        // user table and user models
        'users_table' => 'admin_users',
        'users_model' => Latent\ElAdmin\Models\AdminUser::class,

        'user_roles_table' => 'admin_user_roles',
        'user_roles_model' => Latent\ElAdmin\Models\AdminUserRoles::class,

        'roles_table' => 'admin_roles',
        'roles_model' => Latent\ElAdmin\Models\AdminRole::class,

        'role_menus_table' => 'admin_role_menus',
        'role_menus_model' => Latent\ElAdmin\Models\AdminRoleMenus::class,

        'menus_table' => 'admin_menus',
        'menus_model' =>  Latent\ElAdmin\Models\AdminMenu::class,
    ]
];
