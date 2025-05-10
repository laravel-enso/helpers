<?php

namespace LaravelEnso\Helpers\Enums;

use LaravelEnso\Enums\Contracts\Select;
use LaravelEnso\Enums\Traits\Select as Options;

enum VatRates:int implements Select
{
    use Options;

    case None = 0;
    case Five = 5;
    case Nine = 9;
    case Nineteen = 19;
}
