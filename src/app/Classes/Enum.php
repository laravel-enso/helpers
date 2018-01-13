<?php

namespace LaravelEnso\Helpers\app\Classes;

abstract class Enum
{
    protected static $config;
    protected static $data;

    public static function get(string $key)
    {
        return self::data($key);
    }

    public static function has(string $key)
    {
        $data = self::data();

        return isset($data, $key);
    }

    public static function keys()
    {
        return array_keys(self::data());
    }

    public static function values()
    {
        return array_values(self::data());
    }

    public static function all()
    {
        return self::array();
    }

    public static function json()
    {
        return json_encode(self::data());
    }

    public static function array()
    {
        return self::data();
    }

    public static function object()
    {
        return (object) self::data();
    }

    private static function data(string $key = null)
    {
        $data = isset(static::$config)
            ? config(static::$config)
            : static::$data;

        return !is_null($key)
            ? $data[$key]
            : $data;
    }
}
