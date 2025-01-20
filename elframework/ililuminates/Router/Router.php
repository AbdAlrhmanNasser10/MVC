<?php
namespace Ililuminates\Router;

use Ililuminates\Middleware\Middleware;

class Router
{
    protected static $routes          = [];
    protected static $groupAttributes = [];
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
        $route        = self::applyGroupPerfix($route);
        $middleware   = array_merge(static::getGroupMiddleware(), $middleware);
        self::$routes = [
            'method'      => $method,
            'uri'         => $route,
            '$controller' => $controller,
            'action'      => $action,
            'middleware'  => $middleware,
        ];

        // $route                         = ltrim($route, '/');
        // self::$routes[$method][$route] = compact('controller', 'action', 'middleware');
    }

    public static function group($attributes, $callback)
    {
        $previousGroupAttribute  = static::$groupAttributes;
        static::$groupAttributes = array_merge(static::$groupAttributes, $attributes);
        call_user_func($callback, new self);
        static::$groupAttributes = $previousGroupAttribute;
    }

    protected static function applyGroupPerfix($route)
    {
        if (isset(static::$groupAttributes['prefix'])) {
            $full_route = rtrim(static::$groupAttributes['prefix'], '/') . '/' . ltrim($route, '/');
            return rtrim(ltrim($full_route, '/'), '/');
        } else {
            return $route;
        }
    }

    protected static function getGroupMiddleware()
    {
        return static::$groupAttributes['middleware'] ?? [];
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

        // foreach (static::$routes[$method] as $key => $value) {
        foreach (static::$routes as $route) {
            echo "<pre>";
            var_dump(static::$routes['uri']);

            if (static::$routes['method'] == $method) {
                $pattern = preg_replace('/\{([a-zA-Z0-9_]+)\}/', '(?P<$1>[a-zA-Z0-9_]+)', $route['uri']);
                $pattern = "#^$pattern$#";

                if (preg_match($pattern, $uri, $match)) {
                    $params     = array_filter($match, 'is_string', ARRAY_FILTER_USE_KEY);
                    $controller = $route['controller'];

                    if (is_object($controller)) {

                        $route['middleware'] = $route['action'];
                        $middleware          = $route['middleware'];
                        $next = function ($request) use ($controller, $params) {
                            return $controller(...$params);
                        };

                        //Processing middleware if using anonymous fuction
                        $next = Middleware::handleMiddleware($middleware, $next);

                        echo $next($uri);

                    } else {

                        $action     = $route['action'];
                        $middleware = $route['middleware'];
                        $next       = function ($request) use ($controller, $action, $params) {
                            return call_user_func_array([new $controller, $action], $params);
                        };
                        //Processing middleware if using a controller
                        $next = Middleware::handleMiddleware($middleware, $next);

                        echo $next($uri);
                    }
                }

                return '';
            }
        }

        throw new \Exception("This page $uri not found");
    }
}
