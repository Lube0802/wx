<?php

/*
|--------------------------------------------------------------------------
| Application Routes
|--------------------------------------------------------------------------
|
| Here is where you can register all of the routes for an application.
| It is a breeze. Simply tell Lumen the URIs it should respond to
| and give it the Closure to call when that URI is requested.
|
*/

$app->group(['prefix' => 'api', 'middleware' => ['session']], function () use ($app) {
    require_once __DIR__.'/NoAuthRoute.php';

    $app->group(['middleware' => 'auth'], function () use ($app) {
        require_once __DIR__.'/AuthRoute.php';
    });

    $app->group(['middleware' => 'wechatAuth'], function () use ($app) {
        require_once __DIR__.'/AuthWechatRoute.php';
    });
});
