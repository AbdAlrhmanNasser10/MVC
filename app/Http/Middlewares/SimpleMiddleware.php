<?php
namespace App\Http\Middlewares;

use Contracts\Middleware\Contract;

class SimpleMiddleware implements Contract
{
    public function handle($request, $next,$role = [])
    {
        // var_dump($role);
        if($role[2] == 'group'){
            header('Location: '.url('about'));
            exit;
        }
        return $next($request);
    }
}