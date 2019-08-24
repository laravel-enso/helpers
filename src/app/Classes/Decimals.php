<?php

namespace LaravelEnso\Helpers\app\Classes;

class Decimals
{
    private static $scale = 2;

    public static function scale($precision)
    {
        self::$scale = $precision;
    }

    public static function add($first, $second, $precision = null)
    {
        return bcadd($first, $second, $precision ?? self::$scale);
    }

    public static function sub($first, $second, $precision = null)
    {
        return bcsub($first, $second, $precision ?? self::$scale);
    }

    public static function mul($first, $second, $precision = null)
    {
        return bcmul($first, $second, $precision ?? self::$scale);
    }

    public static function div($first, $second, $precision = null)
    {
        return bcdiv($first, $second, $precision ?? self::$scale);
    }

    public static function sqrt($operand, $precision = null)
    {
        return bcsqrt($operand, $precision ?? self::$scale);
    }

    public static function pow($first, $second, $precision = null)
    {
        return bcpow($first, $second, $precision ?? self::$scale);
    }

    public static function mod($first, $second, $precision = null)
    {
        return bcmod($first, $second, $precision ?? self::$scale);
    }

    public static function powmod($first, $second, $precision = null)
    {
        return bcpowmod($first, $second, $precision ?? self::$scale);
    }

    public static function lt($first, $second, $precision = null)
    {
        return bccomp($first, $second, $precision ?? self::$scale) === -1;
    }

    public static function lte($first, $second, $precision = null)
    {
        return bccomp($first, $second, $precision ?? self::$scale) !== 1;
    }

    public static function eq($first, $second, $precision = null)
    {
        return bccomp($first, $second, $precision ?? self::$scale) === 0;
    }

    public static function notEq($first, $second, $precision = null)
    {
        return bccomp($first, $second, $precision ?? self::$scale) !== 0;
    }

    public static function gt($first, $second, $precision = null)
    {
        return bccomp($first, $second, $precision ?? self::$scale) === 1;
    }

    public static function gte($first, $second, $precision = null)
    {
        return bccomp($first, $second, $precision ?? self::$scale) !== -1;
    }

    public static function ceil($value, $precision = null)
    {
        $scale = pow(10, $precision ?? self::$scale);

        return ceil(self::mul($value, $scale)) / $scale;
    }

    public static function floor($value, $precision = null)
    {
        $scale = pow(10, $precision ?? self::$scale);

        return floor(static::mul($value, $scale)) / $scale;
    }
}
