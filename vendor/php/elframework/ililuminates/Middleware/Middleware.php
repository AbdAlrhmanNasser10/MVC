<?php
namespace Ililuminates\Middleware;

use App\Core;

class Middleware
{
    public static function handleMiddleware($middleware, $next, $type = 'web')
    {
        if (! empty($middleware) && is_array($middleware)) {
            foreach (array_reverse($middleware) as $middle) {
                $next = function ($request) use ($middle, $next, $type) {
                    $role       = explode(',', $middle);
                    $middleware = array_shift($role);
                    if (! class_exists($middleware)) {
                        $middleware = self::getFromCore($middleware, $type);
                    }
                    return (new $middleware)->handle($request, $next, $role);
                };
            }
        }
        return $next;
    }

    public static function getFromCore($key, $type = 'web')
    {
        if ($type == 'web' && isset(Core::$middlewareWebRoute[$key])) {
            return Core::$middlewareWebRoute[$key];
        } else if ($type == 'api' && isset(Core::$middlewareWebRoute[$key])) {
            return Core::$middlewareApiRoute[$key];
        } else {
            throw new \Exception("The Middleware ($key) Not Found");
        }
    }
}
