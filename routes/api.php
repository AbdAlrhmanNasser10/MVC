<?php

use App\Http\Middlewares\SimpleMiddleware;
use Ililuminates\Router\Route;

Route::group(['prefix' => '/api/', 'middleware' => [SimpleMiddleware::class]], function () {
    Route::get('/', fn() => 'Welcome to api page');
    Route::get('/users/', fn() => 'Welcome to users api page');
    Route::get('/article/', fn() => 'Welcome to article api page');
});
