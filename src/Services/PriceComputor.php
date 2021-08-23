<?php

namespace LaravelEnso\Helpers\Services;

class PriceComputor
{
    private string $price;
    private string $vatPercent;
    private int $quantity;
    private string $discountPercent;
    private int $precision;

    public function __construct(string $price)
    {
        $this->price = $price;
        $this->quantity = 1;
        $this->vatPercent = 0;
        $this->discountPercent = 0;
        $this->precision = 2;
    }

    public function quantity(string $quantity): self
    {
        $this->quantity = $quantity;

        return $this;
    }

    public function discountPercent(string $discountPercent): self
    {
        $this->discountPercent = $discountPercent;

        return $this;
    }

    public function vatPercent(string $vatPercent): self
    {
        $this->vatPercent = $vatPercent;

        return $this;
    }

    public function precision(int $precision): self
    {
        $this->precision = $precision;

        return $this;
    }

    public function unitaryPrice(): string
    {
        return $this->round($this->rawUnitaryPrice());
    }

    public function unitaryPriceWithVat(): string
    {
        return $this->round($this->rawUnitaryPriceWithVat());
    }

    public function amount(): string
    {
        return $this->round($this->rawAmount());
    }

    public function discount(): string
    {
        return $this->round($this->rawDiscount());
    }

    public function discountWithVat(): string
    {
        return $this->round($this->rawDiscountWithVat());
    }

    public function vat(): string
    {
        return $this->round($this->rawVat());
    }

    public function total(): string
    {
        return $this->round($this->rawTotal());
    }

    public function totalBeforeDiscount(): string
    {
        return $this->round($this->rawTotalBeforeDiscount());
    }

    public function rawUnitaryPrice(): string
    {
        $sub = Decimals::sub(100, $this->discountPercent, 10);

        $div = Decimals::div($sub, 100, 10);

        return Decimals::mul($this->price, $div, 10);
    }

    public function rawUnitaryPriceWithVat(): string
    {
        $div = Decimals::div($this->vatPercent, 100);
        $vat = Decimals::mul($this->rawUnitaryPrice(), $div, 10);

        return Decimals::add($this->rawUnitaryPrice(), $vat, 10);
    }

    public function rawAmount(): string
    {
        return Decimals::mul($this->rawUnitaryPrice(), $this->quantity, 10);
    }

    public function rawVat(): string
    {
        $div = Decimals::div($this->vatPercent, 100);

        return Decimals::mul($this->rawAmount(), $div, 10);
    }

    public function rawDiscount(): string
    {
        $value = Decimals::mul($this->price, $this->quantity, 10);

        return Decimals::sub($value, $this->rawAmount(), 10);
    }

    public function rawTotalBeforeDiscount(): string
    {
        $amount = Decimals::mul($this->price, $this->quantity, 10);

        $div = Decimals::div($this->vatPercent, 100);

        $vat = Decimals::mul($amount, $div, 10);

        return Decimals::add($amount, $vat, 10);
    }

    public function rawTotal(): string
    {
        return $this->rawAmount() + $this->rawVat();
    }

    public function rawDiscountWithVat(): string
    {
        return Decimals::sub($this->rawTotalBeforeDiscount(), $this->rawTotal(), 10);
    }

    private function round($value): string
    {
        $round = round($value, $this->precision);

        return number_format($round, $this->precision, '.', '');
    }
}
