<?php
// run composer autoload
require_once __DIR__ . "/../vendor/autoload.php";
use Ililuminates\Router\Router;

$router = new Router;
$router->add('GET','/','',function(){
    echo "welcome to index page";
}, []);

$router->dispatch($_SERVER['REQUEST_URI'], $_SERVER['REQUEST_METHOD']);
// echo "<pre>";
// var_dump($router->routes());