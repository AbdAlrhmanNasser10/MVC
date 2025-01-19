<?php
namespace App\Http\Middlewares;

use Contracts\Middleware\Contract;

class SimpleMiddleware implements Contract
{
    public function handle($request, $next, ...$role)
    {
        // var_dump($role[0]);
        if ($role[0] == 'user') {
            header('Location: ' . url('about'));
            exit;
        }
        return $next($request);
    }
}
