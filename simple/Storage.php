<?php

namespace Simple;

class Storage
{
    static private $storage = [];

    public static function set(string $name, $dependency)
    {
        self::$storage[$name] = $dependency;
    }

    public static function get(string $name)
    {
        return self::$storage[$name] ?? null;
    }
}
