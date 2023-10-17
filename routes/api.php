<?php

use Illuminate\Support\Facades\Route;
use Latent\ElAdmin\Helpers;

// all controllers
$config = Helpers::ElConfig();
$controllerMap = $config['controller'];

Route::group([
    'middleware' => 'auth:api',
    'prefix' => '/api/v1/el_admin',
], function () use($controllerMap,$config) {

    Route::post('login', [$controllerMap['auth'],'login'])->withoutMiddleware('auth:api');
    Route::post('logout', [$controllerMap['auth'],'logout']);
    Route::post('refresh', [$controllerMap['auth'],'refresh']);
    Route::post('me', [$controllerMap['auth'],'me']);

    Route::group([
       'middleware' => $config['middleware']['rbac']
    ],function () {

    });

});
