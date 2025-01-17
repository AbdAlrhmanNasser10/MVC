<?php

if(!function_exists('base_path')){
    function base_path(string $file = null){
        return getcwd() . "/../" . $file;
    }
}

if(!function_exists('route_path')){
    function route_path(){
        return config("route.path");
    }
}

if(!function_exists('config')){
    function config(string $file = null){
        if(is_null($file)){
            return '';
        }
        $seprate =  explode('.',$file);
        if (!empty($seprate)){
            $file = include_once base_path("config/") . $seprate[0] . '.php';
            return isset($file[$seprate[1]]) ? $file[$seprate[1]] : $file;
        }
        
        return '';
    }
}