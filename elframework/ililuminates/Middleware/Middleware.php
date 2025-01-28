<?php
namespace Ililuminates\Middleware;
use Ililuminates\Router\Segment;
use App\Core;

class Middleware
{
    public static function handleMiddleware($middleware, $next)
    {
        if (! empty($middleware) && is_array($middleware)) {
            foreach (array_reverse($middleware) as $middle) {
                $next = function ($request) use ($middle, $next) {
                    $role       = explode(',', $middle);
                    $middleware = array_shift($role);
                    if (! class_exists($middleware)) {
                        $middleware = self::getFromCore($middleware);
                    }
                    return (new $middleware)->handle($request, $next, ...$role);
                };
            }
        }
        return $next;
    }

    public static function getFromCore($key)
    {
        $type = Segment::get(0) == 'api' ? 'api' : 'web';
        if ($type == 'web' && isset(Core::$middlewareWebRoute[$key])) {
            return Core::$middlewareWebRoute[$key];
        } else if ($type == 'api' && isset(Core::$middlewareWebRoute[$key])) {
            return Core::$middlewareApiRoute[$key];
        } else {
            throw new \Exception("The Middleware ($key) Not Found");
        }
    }
}
