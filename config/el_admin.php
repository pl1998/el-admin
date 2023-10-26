<?php

/*
 * This file is part of the latent/el-admin.
 *
 * (c) latent<pltrueover@gmail.com>
 *
 * This source file is subject to the MIT license that is bundled
 * with this source code in the file LICENSE.
 */

return [
    /*
    |--------------------------------------------------------------------------
    | el-admin logo
    |--------------------------------------------------------------------------
    |
    */
    'logo' => 'logo.png',

    /*
   |--------------------------------------------------------------------------
   | el-admin jwt guard
   |--------------------------------------------------------------------------
   |
   */

    'guard' => 'api',
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

    // Whether to enable database logging
    'log' => true,

    // Log filtering request method records
    'log_filter_method' => [
        Latent\ElAdmin\Enum\MethodEnum::GET,
        Latent\ElAdmin\Enum\MethodEnum::OPTIONS,
        Latent\ElAdmin\Enum\MethodEnum::HEAD,
    ],

    'log_class' => Latent\ElAdmin\Services\LogWriteService::class,

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
        'user_roles_model' => Latent\ElAdmin\Models\AdminUserRole::class,

        'roles_table' => 'admin_roles',
        'roles_model' => Latent\ElAdmin\Models\AdminRole::class,

        'role_menus_table' => 'admin_role_menus',
        'role_menus_model' => Latent\ElAdmin\Models\AdminRoleMenu::class,

        'menus_table' => 'admin_menus',
        'menus_model' => Latent\ElAdmin\Models\AdminMenu::class,

        'log_table' => 'admin_logs',
        'log_model' => Latent\ElAdmin\Models\AdminLog::class,

        'connection' => 'mysql',
    ],

    /*
    |--------------------------------------------------------------------------
    | el-admin  menus settings
    |--------------------------------------------------------------------------
    |
    | el-admin  menus settings
    |
    */
    'menus' => [
        /* @var bool Whether to enable menu caching */
        'cache' => false,
        /* @var int Cache expiration time (minutes) */
        'ttl' => 60,
        /* @var string cache disk */
        'disk' => 'file',
        'prefix' => 'el:admin:menu_',
    ],
];
