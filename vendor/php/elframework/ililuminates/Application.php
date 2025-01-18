<?php
namespace Ililuminates;

use Ililuminates\Router\Route;
use Ililuminates\Sessions\Session;

class Application
{
    protected $router;

    public function start()
    {
        session_save_path(config('session.session_save_path'));
        ini_set('session.gc_probability', 1);
        session_start([
            'cookie_lifetime'=>config('session.expiration_timeout')
        ]);

        Session::make('message','Welcome Message From Sessions');
        
        $this->router = new Route;
        include route_path('web.php');
    }

    public function __destruct()
    {
        $this->router->dispatch($_SERVER['REQUEST_URI'], $_SERVER['REQUEST_METHOD']);
    }
}
