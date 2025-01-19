<?php
namespace App;

class Core
{
    public static $globalWeb = [
        \Ililuminates\Sessions\Session::class,
    ];

    public static $middlewareWebRoute = [
        'simple' => \App\Http\Middlewares\SimpleMiddleware::class,
    ];

    public static $middlewareApiRoute = [];

    public static $globalApi = [];
}
