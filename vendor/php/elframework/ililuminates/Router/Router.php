<?php
namespace Ililuminates\Router;


class Router
{
    protected static $routes = [
        'GET'=>[],
        'POST'=>[],
        'PUT'=>[],
        'PATCH'=>[],
        'DELETE'=>[]
    ];

    /**
     * @param string $method
     * @param string $route
     * @param mixed $controller
     * @param mixed $action
     * @param array $middlewares
     * 
     * @return void
     */
    public static function add(string $method , string $route , $controller,$action, array $middlewares = [] ){
        $route = ltrim($route,'/');
        self::$routes[$method][$route] = compact('controller', 'action', 'middlewares');
    }

    /**
     * @return static routes
     */
    public function routes(){
        return static::$routes;
    }

    /**
     * @param mixed $uri
     * @param mixed $method
     * 
     * @return void
     */
    public static function dispatch($uri,$method){
        $uri = ltrim($uri,'/MVC/public/');
        if(isset(static::$routes[$method][$uri])){
        $data = static::$routes[$method][$uri];

        if(is_object($data['action'])){
            $data['action']();
        }else{
            call_user_func_array([new $data['controller'],$data['action']] , []);
        }

        }else{
            throw new \Exception("This page $uri not found");
        }
    }
}