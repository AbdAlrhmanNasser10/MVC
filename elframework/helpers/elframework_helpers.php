<?php

if (! function_exists('base_path')) {
    function base_path(string $file = null)
    {
        return getcwd() . "/../" . $file;
    }
}

if (! function_exists('route_path')) {
    function route_path(string $file = null)
    {
        return ! is_null($file) ? config("route.path") . "/$file" : config("route.path");
    }
}

if (! function_exists('config')) {
    function config(string $file = null)
    {
        $seprate = explode('.', $file);

        if ((! empty($seprate) && count($seprate) > 1) && (! is_null($file))) {
            $file = include_once base_path("config/") . $seprate[0] . '.php';
            return isset($file[$seprate[1]]) ? $file[$seprate[1]] : $file;
        }

        return $file;
    }
}

if (! function_exists('public_path')) {
    function public_path(string $file = null)
    {
        return ! empty($file) ? getcwd() . "/$file" : getcwd();
    }
}
