<?php
namespace Contracts\Middleware;

interface Contract
{
    public function handle($request, $next, ...$role);
}
