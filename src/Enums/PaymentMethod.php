<?php

namespace LaravelEnso\Helpers\Enums;

use LaravelEnso\Enums\Contracts\Mappable;
use LaravelEnso\Enums\Contracts\Select;
use LaravelEnso\Enums\Traits\Select as Options;

enum PaymentMethod: int implements Mappable, Select
{
    use Options;

    case Card = 1;
    case OnDelivery = 2;
    case Wire = 3;
    case PromissoryNote = 4;
    case Cash = 5;
    case Cheque = 6;

    public function map(): string
    {
        return match ($this) {
            self::Card => 'Card',
            self::OnDelivery => 'On Delivery',
            self::Wire => 'Transfer',
            self::PromissoryNote => 'Promissory Note',
            self::Cash => 'Cash',
            self::Cheque => 'Cheque',
        };
    }
}
