<?php
namespace Ililuminates\Router;

class Router
{
    protected static $routes = [
        'GET'    => [],
        'POST'   => [],
        'PUT'    => [],
        'PATCH'  => [],
        'DELETE' => [],
    ];

    private static $public;

    /**
     * @return string
     */
    public static function public_path($bind = null): string
    {
        static::$public = $bind ?? '/MVC/public/';
        return static::$public;
    }
    /**
     * @param string $method
     * @param string $route
     * @param mixed $controller
     * @param mixed $action
     * @param array $middlewares
     *
     * @return void
     */
    public static function add(string $method, string $route, $controller, $action, array $middlewares = [])
    {
        $route                         = ltrim($route, '/');
        self::$routes[$method][$route] = compact('controller', 'action', 'middlewares');
    }

    /**
     * @return static routes
     */
    public function routes()
    {
        return static::$routes;
    }

    /**
     * @param mixed $uri
     * @param mixed $method
     *
     * @return void
     */
    public static function dispatch($uri, $method)
    {
        $uri = ltrim($uri, '/' . static::public_path() . '/');

        foreach (static::$routes[$method] as $key => $value) {
            $pattern = preg_replace('/\{([a-zA-Z0-9_]+)\}/', '(?P<$1>[a-zA-Z0-9_]+)', $key);
            $pattern = "#^$pattern$#";

            if (preg_match($pattern, $uri, $match)) {
                $controller  = $value['controller'];
                $action      = $value['action'];
                $middlewares = $value['middlewares'];
                $params      = array_filter($match, 'is_string', ARRAY_FILTER_USE_KEY);
                // var_dump($params);
                return call_user_func_array([new $controller, $action], $params);
            }
        }

        throw new \Exception("This page $uri not found");
    }
}
