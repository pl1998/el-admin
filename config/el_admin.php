<?php

return [
    /*
      |--------------------------------------------------------------------------
      | el-admin controller settings
      |--------------------------------------------------------------------------
      |
      | Here are controller settings for el-admin builtin controller.
      |
      */

    'controller' => [
        'auth' => ElAdmin\LaravelVueAdmin\Controller\AuthController::class
    ],

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
        'rbac' => ElAdmin\LaravelVueAdmin\Middleware\RbacMiddleware::class,
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
        'users_model' => ElAdmin\LaravelVueAdmin\Models\AdminUser::class
    ]
];
