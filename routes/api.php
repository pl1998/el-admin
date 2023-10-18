<?php

use Illuminate\Support\Facades\Route;
use Latent\ElAdmin\Controller\AuthController;
use Latent\ElAdmin\Middleware\RbacMiddleware;
use Latent\ElAdmin\Controller\RolesController;

Route::group([
    'middleware' => 'auth:api',
    'prefix' => 'api/v1/el_admin',
], function () {

    Route::post('login', [AuthController::class,'login'])->withoutMiddleware('auth:api');
    Route::post('logout', [AuthController::class,'logout']);
    Route::post('refresh', [AuthController::class,'refresh']);
    Route::post('me', [AuthController::class,'me']);

    Route::post('role', [RolesController::class,'store']);
    Route::put('role', [RolesController::class,'update']);

    Route::group([
       'middleware' =>RbacMiddleware::class
    ],function () {

    });
});
