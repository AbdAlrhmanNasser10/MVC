<?php
namespace Ililuminates;

use Ililuminates\Router\Route;
use App\Http\Controllers\HomeController;

class Application
{
    protected $router;


    public function start(){
        $this->router = new Route;
        include route_path();

    }

    public function __destruct(){
        $this->router->dispatch($_SERVER['REQUEST_URI'], $_SERVER['REQUEST_METHOD']);
    }
}