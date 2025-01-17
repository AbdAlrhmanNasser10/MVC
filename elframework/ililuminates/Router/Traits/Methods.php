<?php
namespace Ililuminates\Router\Traits;

trait Methods
{
    
    /**
     * @param string $route
     * @param mixed $controller
     * @param mixed $action
     * @param array $middlewares
     * 
     * @return void
     */
    public static function get(string $route , $controller,$action, array $middlewares = []):void{
        parent::add('GET',$route , $controller,$action,  $middlewares);
    }

    /**
     * @param string $route
     * @param mixed $controller
     * @param mixed $action
     * @param array $middlewares
     * 
     * @return void
     */
    public static function post(string $route , $controller,$action, array $middlewares = []):void{
        parent::add('POST',$route , $controller,$action,  $middlewares);
    }

    /**
     * @param string $route
     * @param mixed $controller
     * @param mixed $action
     * @param array $middlewares
     * 
     * @return void
     */
    public static function put(string $route , $controller,$action, array $middlewares = []):void{
        parent::add('PUT',$route , $controller,$action,  $middlewares);
    }

    
    /**
     * @param string $route
     * @param mixed $controller
     * @param mixed $action
     * @param array $middlewares
     * 
     * @return void
     */
    public static function patch(string $route , $controller,$action, array $middlewares = []):void{
        parent::add('PATCH',$route , $controller,$action,  $middlewares);
    }


    /**
     * @param string $route
     * @param mixed $controller
     * @param mixed $action
     * @param array $middlewares
     * 
     * @return void
     */
    public static function delete(string $route , $controller,$action, array $middlewares = []):void{
        parent::add('DELETE',$route , $controller,$action,  $middlewares);
    }

    
}