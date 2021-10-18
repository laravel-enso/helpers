<?php

namespace LaravelEnso\Helpers\Enums;

use LaravelEnso\Enums\Services\Enum;

class PaymentMethods extends Enum
{
    public const Card = 1;
    public const OnDelivery = 2;
    public const Wire = 3;
    public const PromissoryNote = 4;
    public const Cash = 5;
    public const Cheque = 6;

    protected static array $data = [
        self::Card => 'Card',
        self::OnDelivery => 'On Delivery',
        self::Wire => 'Transfer',
        self::PromissoryNote => 'Promissory Note',
        self::Cash => 'Cash',
        self::Cheque => 'Cheque',
    ];
}
