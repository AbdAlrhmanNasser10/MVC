<?php
use App\Http\Middlewares\SimpleMiddleware;
use App\Http\Middlewares\UsersMiddleware;
use Ililuminates\Router\Route;

Route::group(['prefix' => '/api/', 'middleware' => [SimpleMiddleware::class]], function () {
    Route::get('/', function () {
        return 'Welcome to api page';
    });

    Route::get('users', function () {
        return 'Welcome to users api page';
    });

    Route::get('article', function () {
        return 'Welcome to article api page';
    });
});
