<?php


namespace Think\Core\Bean;


class BeanFactory
{
    private static $container = [];

    public static function set(string $name,callable $func){
        self::$container[$name] = $func;
    }

    public static function get($name){
        if (isset(self::$container[$name])) {
            return (self::$container[$name])();
        }
        return null;
    }
}