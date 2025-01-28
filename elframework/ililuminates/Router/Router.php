<?php
namespace Ililuminates\Router;

use Exception;
use Ililuminates\Middleware\Middleware;

class Router
{
    protected static $routes          = [];
    protected static $groupAttributes = [];
    private static $public;

    /**
     * Set or return the public path.
     */
    public static function public_path($bind = null): string
    {
        static::$public = $bind ?? '/MVC/public/';
        return static::$public;
    }

    /**
     * Add a new route.
     */
    public static function add(string $method, string $route, $controller, $action = null, array $middleware = [])
    {
        $route          = self::applyGroupPerfix($route);
        $middleware     = array_merge(static::getGroupMiddleware(), $middleware);
        self::$routes[] = [
            'method'     => $method,
            'uri'        => ltrim($route,'/'),
            'controller' => $controller,
            'action'     => $action,
            'middleware' => $middleware,
        ];
    }

    /**
     * Group routes together.
     */
    public static function group($attributes, $callback)
    {
        $previousGroupAttribute  = static::$groupAttributes;
        static::$groupAttributes = array_merge(static::$groupAttributes, $attributes);
        call_user_func($callback, new self);
        static::$groupAttributes = $previousGroupAttribute;
    }

    /**
     * Apply the group prefix to the route.
     */
    protected static function applyGroupPerfix($route)
    {
        if (isset(static::$groupAttributes['prefix'])) {
            $full_route = rtrim(static::$groupAttributes['prefix'], '/') . '/' . ltrim($route, '/');
            return rtrim(ltrim($full_route, '/'), '/');
        }
        return $route;
    }

    /**
     * Get the middleware for the current group.
     */
    protected static function getGroupMiddleware()
    {
        return static::$groupAttributes['middleware'] ?? [];
    }

    /**
     * Return all routes.
     */
    public function routes()
    {
        return static::$routes;
    }

    /**
     * Dispatch the request to the appropriate route.
     */
    public static function dispatch($uri, $method)
    {
        $uri =  ltrim($uri, '/' . static::public_path() . '/');
        $uri = empty($uri) ? '/' : $uri;
        foreach (static::$routes as $route) {
            if ($route['method'] == $method) {
                
                $pattern = preg_replace('/\{([a-zA-Z0-9_]+)\}/', '(?P<$1>[a-zA-Z0-9_]+)', $route['uri']);
                $pattern = "#^$pattern$#";

                if (preg_match($pattern, $uri, $match)) {
                    $params = array_filter($match, 'is_string', ARRAY_FILTER_USE_KEY);

                    if (is_object($route['controller'])) {
                        $middleware = $route['action'];
                        $next       = function ($request) use ($route, $params) {
                            return $route['controller'](...$params);
                        };
                    } else {
                        $middleware = $route['middleware'];
                        $next       = function ($request) use ($route, $params) {
                            return call_user_func_array([new $route['controller'], $route['action']], $params);
                        };
                    }

                    // Process middleware
                    $next = Middleware::handleMiddleware($middleware, $next);
                    echo $next($uri);
                    return;
                }
            }
        }

        throw new Exception("The requested page ($uri) was not found.");
    }
}
