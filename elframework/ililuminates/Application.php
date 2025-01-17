<?php
namespace Ililuminates;

use Ililuminates\Router\Router;
use App\Http\Controllers\HomeController;

class Application
{
    public function start(){
        $router = new Router;
        $router->add('GET','/',HomeController::class,'index');
        $router->add('GET','/about',HomeController::class,'about');

        $router->dispatch($_SERVER['REQUEST_URI'], $_SERVER['REQUEST_METHOD']);
    }
}