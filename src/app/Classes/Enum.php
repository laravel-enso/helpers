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

    public static function select()
    {
        return collect(self::data())->map(function ($value, $key) {
            return (object) ['id' => $key, 'name' => $value];
        })->values();
    }

    private static function data(string $key = null)
    {
        $data = isset(static::$config)
            ? config(static::$config)
            : static::$data;

        return !is_null($key)
            ? __($data[$key])
            : self::trans($data);
    }

    private static function trans($data)
    {
        \Log::info('adf');

        return collect($data)->map(function ($value) {
            return __($value);
        });
    }
}
