<?php

use App\Http\Controllers\HomeController;
use Ililuminates\Router\Route;

Route::get('/', HomeController::class, 'index', []);
Route::get('/', fn() => "Welcome to index page");
Route::get('/about', HomeController::class, 'about', []);
// Route::get('/article/{id}', HomeController::class, 'article', []);
Route::get('/article/{id}/{name}', function ($id, $name) {
    return $id . " " . $name;
});
