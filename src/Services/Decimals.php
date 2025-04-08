<?php

namespace LaravelEnso\Helpers\Services;

class Decimals
{
    private static int $scale = 4;

    public static function scale(?int $precision = null): int
    {
        if ($precision) {
            self::$scale = $precision;
        }

        return self::$scale;
    }

    public static function add($first, $second, ?int $precision = null): string
    {
        return bcadd($first, $second, $precision ?? self::$scale);
    }

    public static function sub($first, $second, ?int $precision = null): string
    {
        return bcsub($first, $second, $precision ?? self::$scale);
    }

    public static function mul($first, $second, ?int $precision = null): string
    {
        return bcmul($first, $second, $precision ?? self::$scale);
    }

    public static function div($first, $second, ?int $precision = null): string
    {
        return bcdiv($first, $second, $precision ?? self::$scale);
    }

    public static function sqrt($operand, ?int $precision = null): string
    {
        return bcsqrt($operand, $precision ?? self::$scale);
    }

    public static function pow($first, $second, ?int $precision = null): string
    {
        return bcpow($first, $second, $precision ?? self::$scale);
    }

    public static function mod($first, $second, ?int $precision = null): string
    {
        return bcmod($first, $second, $precision ?? self::$scale);
    }

    public static function powmod($first, $second, ?int $precision = null): string
    {
        return bcpowmod($first, $second, $precision ?? self::$scale);
    }

    public static function lt($first, $second, ?int $precision = null): bool
    {
        return bccomp($first, $second, $precision ?? self::$scale) === -1;
    }

    public static function lte($first, $second, ?int $precision = null): bool
    {
        return bccomp($first, $second, $precision ?? self::$scale) !== 1;
    }

    public static function eq($first, $second, ?int $precision = null): bool
    {
        return bccomp($first, $second, $precision ?? self::$scale) === 0;
    }

    public static function notEq($first, $second, ?int $precision = null): bool
    {
        return bccomp($first, $second, $precision ?? self::$scale) !== 0;
    }

    public static function gt($first, $second, ?int $precision = null): bool
    {
        return bccomp($first, $second, $precision ?? self::$scale) === 1;
    }

    public static function gte($first, $second, ?int $precision = null): bool
    {
        return bccomp($first, $second, $precision ?? self::$scale) !== -1;
    }

    public static function ceil($value, ?int $precision = null): string
    {
        $precision ??= self::$scale;
        $scale = pow(10, $precision);
        $ceil = ceil((float) self::mul($value, $scale));

        return self::div($ceil, $scale, $precision);
    }

    public static function floor($value, ?int $precision = null): string
    {
        $precision ??= self::$scale;
        $scale = pow(10, $precision ?? self::$scale);
        $floor = floor((float) self::mul($value, $scale));

        return self::div($floor, $scale, $precision);
    }

    public static function round($value, ?int $precision = null): string
    {
        $precision ??= self::$scale;
        $scale = pow(10, $precision ?? self::$scale);
        $round = round((float) self::mul($value, $scale));

        return self::div($round, $scale, $precision);
    }

    public static function min($first, $second, ?int $precision = null): string
    {
        return self::lte($first, $second, $precision) ? $first : $second;
    }

    public static function max($first, $second, ?int $precision = null): string
    {
        return self::gte($first, $second, $precision) ? $first : $second;
    }
}
