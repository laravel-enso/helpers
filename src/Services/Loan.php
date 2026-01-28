<?php

namespace LaravelEnso\Helpers\Services;

class Loan
{
    public function __construct(
        private string $amount,
        private int $months,
        private string $yearlyInterest,
        private string $administrationFee = '0',
        private string $residualValuePercentage = '0',
    ) {
    }

    public function monthlyRate(): string
    {
        $scale = Decimals::scale();
        Decimals::scale(10);

        $rate = Decimals::add(
            $this->monthlyAdministrationTax(),
            Decimals::add($this->capitalRate(), $this->residualValueRate())
        );

        Decimals::scale($scale);

        return Decimals::ceil($rate, $scale);
    }

    private function monthlyMultiplier(): string
    {
        $monthlyInterest = Decimals::div($this->yearlyInterest, 12);

        return Decimals::div($monthlyInterest, 100);
    }

    private function factor(): string
    {
        $addition = Decimals::add(1, $this->monthlyMultiplier());

        return Decimals::pow($addition, $this->months);
    }

    private function capitalRate(): string
    {
        $residualValue = Decimals::mul(
            $this->amount,
            Decimals::div($this->residualValuePercentage, 100)
        );
        $mul = Decimals::mul($residualValue, $this->monthlyMultiplier());

        return Decimals::div($mul, Decimals::sub($this->factor(), 1));
    }

    private function residualValueRate(): string
    {
        $mul = Decimals::mul(
            Decimals::mul($this->amount, $this->monthlyMultiplier()),
            $this->factor(),
        );

        return Decimals::div($mul, Decimals::sub($this->factor(), 1));
    }

    private function monthlyAdministrationTax(): string
    {
        $div = Decimals::div($this->administrationFee, 100);

        $mul = Decimals::mul($div, $this->amount);

        return Decimals::div($mul, $this->months);
    }
}
