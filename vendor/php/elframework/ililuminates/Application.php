<?php
namespace Ililuminates;

use Ililuminates\Router\Route;

class Application
{
    protected $router;

    public function start()
    {
        $this->router = new Route;
        include route_path('web.php');
    }

    public function __destruct()
    {
        $this->router->dispatch($_SERVER['REQUEST_URI'], $_SERVER['REQUEST_METHOD']);
    }
}
