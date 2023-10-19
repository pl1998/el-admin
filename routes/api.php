<?php

use Illuminate\Support\Facades\Route;
use Latent\ElAdmin\Controller\AuthController;
use Latent\ElAdmin\Middleware\RbacMiddleware;
use Latent\ElAdmin\Controller\RolesController;
use Latent\ElAdmin\Controller\MenusController;
use Latent\ElAdmin\Controller\UsersController;
use Latent\ElAdmin\Controller\LogsController;

Route::group([
    'middleware' => ['auth:api'],
    'prefix' => 'api/v1/el_admin',
], function () {

    Route::post('login', [AuthController::class,'login'])->withoutMiddleware('auth:api');
    Route::post('logout', [AuthController::class,'logout']);
    Route::post('refresh', [AuthController::class,'refresh']);
    Route::post('me', [AuthController::class,'me']);

    Route::group([
       'middleware' =>RbacMiddleware::class
    ],function () {

        Route::resource('role',RolesController::class)->only([
            'index','store', 'update', 'destroy'
        ]);
        Route::resource('menu',MenusController::class)->only([
            'index','store', 'update', 'destroy'
        ]);
        Route::resource('user',UsersController::class)->only([
            'index','store', 'update', 'destroy'
        ]);
        Route::resource('log',LogsController::class)->only([
            'index', 'destroy'
        ]);

        Route::get('roleMenus', [MenusController::class,'getRoleMenu']);

    });
});
