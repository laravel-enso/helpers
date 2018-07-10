<?php

namespace LaravelEnso\Helpers\app\Classes;

use ReflectionClass;

abstract class Enum
{
    protected static $data;

    protected static function attributes()
    {
        // return [];
    }

    private static function constants()
    {
        $constants = array_flip(
            (new ReflectionClass(static::class))
                ->getConstants()
        );

        return count($constants)
            ? $constants
            : null;
    }

    public static function get(string $key)
    {
        return self::data($key);
    }

    public static function has(string $key)
    {
        return self::data()->has($key);
    }

    public static function keys()
    {
        return self::data()->keys();
    }

    public static function values()
    {
        return self::data()->values();
    }

    public static function all()
    {
        return self::array();
    }

    public static function json()
    {
        return json_encode(self::array());
    }

    public static function array()
    {
        return self::data()->toArray();
    }

    public static function object()
    {
        return (object) self::array();
    }

    public static function collection()
    {
        return self::data();
    }

    public static function select()
    {
        return collect(self::data())->map(function ($value, $key) {
            return (object) ['id' => $key, 'name' => $value];
        })->values();
    }

    private static function data(string $key = null)
    {
        $data = static::constants()
            ?? static::attributes()
            ?? static::$data;

        return is_null($key)
            ? static::transAll($data)
            : static::trans($data[$key]);
    }

    private static function transAll($data)
    {
        return collect($data)->map(function ($value) {
            return self::trans($value);
        });
    }

    private static function trans($value)
    {
        return is_string($value)
            ? __($value)
            : $value;
    }
}
