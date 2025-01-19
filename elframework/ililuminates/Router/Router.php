<?php
namespace Ililuminates\Router;

use Ililuminates\Middleware\Middleware;

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
     * @param array $middleware
     *
     * @return void
     */
    public static function add(string $method, string $route, $controller, $action = null, array $middleware = [])
    {
        $route                         = ltrim($route, '/');
        self::$routes[$method][$route] = compact('controller', 'action', 'middleware');
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
                $params     = array_filter($match, 'is_string', ARRAY_FILTER_USE_KEY);
                $controller = $value['controller'];

                if (is_object($controller)) {

                    $value['middleware'] = $value['action'];
                    $middleware          = $value['middleware'];

                    $next = function ($request) use ($controller, $params) {
                        return $controller(...$params);
                    };

                    //Processing middleware if using anonymous fuction
                    $next = Middleware::handleMiddleware($middleware, $next);

                    echo $next($uri);

                } else {

                    $action     = $value['action'];
                    $middleware = $value['middleware'];
                    $next       = function ($request) use ($controller, $action, $params) {
                        return call_user_func_array([new $controller, $action], $params);
                    };
                    //Processing middleware if using a controller
                    $next = Middleware::handleMiddleware($middleware, $next);

                    echo $next($uri);
                }

                return '';
            }
        }

        throw new \Exception("This page $uri not found");
    }
}
