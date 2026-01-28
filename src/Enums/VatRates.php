<?php

namespace LaravelEnso\Helpers\Enums;

use LaravelEnso\Enums\Services\Enum;

class VatRates extends Enum
{
    public const None = 0;
    public const Five = 5;
    public const Nine = 9;
    public const Eleven = 11;
    public const Nineteen = 19;
    public const TwentyOne = 21;

    public static function multiplier(int $vatRate): string
    {
        return 1 + $vatRate / 100;
    }
}
