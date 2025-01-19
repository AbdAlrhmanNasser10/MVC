<?php

use App\Http\Controllers\HomeController;
use App\Http\Middlewares\SimpleMiddleware;
use Ililuminates\Router\Route;
use Ililuminates\Sessions\Session;

Route::get('/', HomeController::class, 'index', []);
Route::get('/', function(){
    return "Welcome to index page";
},[SimpleMiddleware::class . ',user,admin,group']);
Route::get('/about', HomeController::class, 'about');
// Route::get('/article/{id}', HomeController::class, 'article', []);
Route::get('/article/{id}/{name}', function ($id, $name) {
    return $id . " " . $name;
});
