<?php
namespace Ililuminates\Router;

class Router
{
    protected $routes = [
        'GET'=>[],
        'POST'=>[],
        'PUT'=>[],
        'PATCH'=>[],
        'DELETE'=>[]
    ];

    public function add(string $method , string $route , $controller,$action, array $middlewares = [] ){
        $this->routes[$method][$route] = compact('controller', 'action', 'middlewares');
    }

    public function routes(){
        return $this->routes;
    }

    public function dispatch($uri,$method){
        $uri = str_replace($uri,'/MVC/public/','/');
        $data = $this->routes[$method][$uri];
        $data['action']();
    }
}