<?php

namespace LaravelEnso\Helpers\app\Classes;

class Decimals
{
    private static $scale = 2;

    public static function scale($precision)
    {
        self::$scale = $precision;
    }

    public static function add($first, $second)
    {
        return bcadd($first, $second, self::$scale);
    }

    public static function sub($first, $second)
    {
        return bcsub($first, $second, self::$scale);
    }

    public static function mul($first, $second)
    {
        return bcmul($first, $second, self::$scale);
    }

    public static function div($first, $second)
    {
        return bcdiv($first, $second, self::$scale);
    }

    public static function sqrt($operand)
    {
        return bcsqrt($operand, self::$scale);
    }

    public static function pow($first, $second)
    {
        return bcpow($first, $second, self::$scale);
    }

    public static function mod($first, $second)
    {
        return bcmod($first, $second, self::$scale);
    }

    public static function powmod($first, $second)
    {
        return bcpowmod($first, $second, self::$scale);
    }

    public static function lt($first, $second)
    {
        return bccomp($first, $second, self::$scale) === -1;
    }

    public static function lte($first, $second)
    {
        return bccomp($first, $second, self::$scale) !== 1;
    }

    public static function eq($first, $second)
    {
        return bccomp($first, $second, self::$scale) === 0;
    }

    public static function gt($first, $second)
    {
        return bccomp($first, $second, self::$scale) === 1;
    }

    public static function gte($first, $second)
    {
        return bccomp($first, $second, self::$scale) !== -1;
    }
}
