<?php

namespace LaravelEnso\Helpers\Services;

class Loan
{
    public function __construct(
        private string $amount,
        private int $months,
        private string $yearlyInterest,
        private ?int $scale = 100,
    ) {
    }

    public function monthlyRate(): string
    {
        $scale = Decimals::scale();
        Decimals::scale($this->scale);

        $monthlyInterest = Decimals::div($this->yearlyInterest, 12);
        $monthlyMultiplier = Decimals::div($monthlyInterest, 100);
        $addition = Decimals::add(1, $monthlyMultiplier);
        $factor = Decimals::pow($addition, $this->months);

        $division = Decimals::div(
            Decimals::mul($monthlyMultiplier, $factor),
            Decimals::sub($factor, 1)
        );

        Decimals::scale($scale);

        return Decimals::mul($this->amount, $division);
    }
}
