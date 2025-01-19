<?php
namespace Ililuminates;

use App\Core;
use Ililuminates\Router\Route;

class Application
{
    protected $router;

    public function start()
    {
        $this->router = new Route;
        $this->webRoute();
    }

    public function __destruct()
    {
        $this->router->dispatch($_SERVER['REQUEST_URI'], $_SERVER['REQUEST_METHOD']);
    }

    public function webRoute()
    {

        foreach (Core::$globalWeb as $golbal) {
            new $golbal();
        }
        include route_path('web.php');
    }

    public function apiRoute()
    {
        foreach (Core::$globalApi as $golbal) {
            new $golbal();
        }
        include route_path('api.php');
    }
}
