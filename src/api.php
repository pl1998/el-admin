<?php

/*
 * This file is part of the latent/el-admin.
 *
 * (c) latent<pltrueover@gmail.com>
 *
 * This source file is subject to the MIT license that is bundled
 * with this source code in the file LICENSE.
 */

use Illuminate\Support\Facades\Route;
use Latent\ElAdmin\Controller\AuthController;
use Latent\ElAdmin\Controller\LogsController;
use Latent\ElAdmin\Controller\MenusController;
use Latent\ElAdmin\Controller\RolesController;
use Latent\ElAdmin\Controller\UsersController;
use Latent\ElAdmin\Middleware\RbacMiddleware;

Route::group([
    'middleware' => ['auth:api'],
    'prefix' => 'api/v1/el_admin',
], function () {
    Route::post('login', [AuthController::class, 'login'])->withoutMiddleware('auth:api');
    Route::post('logout', [AuthController::class, 'logout']);
    Route::post('refresh', [AuthController::class, 'refresh']);
    Route::post('me', [AuthController::class, 'me']);
    Route::get('getRouteList', [MenusController::class, 'getRouteList']);
    Route::get('getAllMenus', [MenusController::class, 'getAllMenus']);
    Route::get('getAllRole', [RolesController::class, 'getAllRole']);
    Route::get('roleMenus', [MenusController::class, 'getRoleMenu']);
    Route::group([
        'middleware' => RbacMiddleware::class,
    ], function () {
        Route::resource('role', RolesController::class)->only([
            'index', 'store', 'update', 'destroy',
        ]);
        Route::resource('menu', MenusController::class)->only([
            'index', 'store', 'update', 'destroy',
        ]);
        Route::resource('user', UsersController::class)->only([
            'index', 'store', 'update', 'destroy',
        ]);
        Route::resource('log', LogsController::class)->only([
            'index', 'destroy',
        ]);
    });
});
