<?php

use Illuminate\Support\Facades\Route;
use ElAdmin\LaravelVueAdmin\Helpers;

// all controllers
$controllerMap = config('el_admin.controller') ?? [];

if(empty($controllerMap)) {
    $controllerMap = Helpers::ElConfig('controller');
}
Route::group([
    'middleware' => 'auth:sanctum',
    'prefix' => 'api/v1/el_admin',
], function () use($controllerMap) {

    Route::post('login', [$controllerMap['auth'],'login'])->name('admin.login');
    Route::post('logout', [$controllerMap['auth'],'logout']);
    Route::post('refresh', [$controllerMap['auth'],'refresh']);
    Route::post('me', [$controllerMap['auth'],'me']);

});
