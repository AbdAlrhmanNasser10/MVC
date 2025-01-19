<?php
namespace Ililuminates\Router;

class Segment
{
    public static function uri(){
        return str_replace('/MVC/public/', '', $_SERVER['REQUEST_URI']);
    }


    public static function get(int $offset):string
    {
        $uri = static::uri();
        $segment = explode('/',$uri);
        return isset($segment[$offset]) ? $segment[$offset] : '';
    }

    public static function all(){
        return explode('/',static::uri());
    }
}
