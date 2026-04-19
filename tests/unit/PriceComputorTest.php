<?php

use PHPUnit\Framework\Attributes\Test;
use LaravelEnso\Helpers\Services\PriceComputor;
use Tests\TestCase;

class PriceComputorTest extends TestCase
{
    #[Test]
    public function computes_the_expected_pricing_summary()
    {
        $computor = (new PriceComputor('100'))
            ->quantity('2')
            ->discountPercent('10')
            ->vatPercent('19');

        $this->assertSame('90.00', $computor->unitaryPrice());
        $this->assertSame('107.10', $computor->unitaryPriceWithVat());
        $this->assertSame('180.00', $computor->amount());
        $this->assertSame('20.00', $computor->discount());
        $this->assertSame('23.80', $computor->discountWithVat());
        $this->assertSame('34.20', $computor->vat());
        $this->assertSame('214.20', $computor->total());
        $this->assertSame('238.00', $computor->totalBeforeDiscount());
    }

    #[Test]
    public function respects_custom_precision_for_rounded_values()
    {
        $computor = (new PriceComputor('12.3456'))
            ->quantity('3')
            ->discountPercent('5')
            ->vatPercent('19')
            ->precision(3);

        $this->assertSame('11.728', $computor->unitaryPrice());
        $this->assertSame('13.957', $computor->unitaryPriceWithVat());
        $this->assertSame('35.185', $computor->amount());
        $this->assertSame('1.852', $computor->discount());
        $this->assertSame('2.204', $computor->discountWithVat());
        $this->assertSame('6.685', $computor->vat());
        $this->assertSame('41.870', $computor->total());
        $this->assertSame('44.074', $computor->totalBeforeDiscount());
    }

    #[Test]
    public function exposes_unrounded_values_for_downstream_calculations()
    {
        $computor = (new PriceComputor('10'))
            ->quantity('3')
            ->discountPercent('12.5')
            ->vatPercent('19');

        $this->assertSame('8.7500000000', $computor->rawUnitaryPrice());
        $this->assertSame('10.4125000000', $computor->rawUnitaryPriceWithVat());
        $this->assertSame('26.2500000000', $computor->rawAmount());
        $this->assertSame('4.9875000000', $computor->rawVat());
        $this->assertSame('3.7500000000', $computor->rawDiscount());
        $this->assertSame('35.7000000000', $computor->rawTotalBeforeDiscount());
        $this->assertSame('31.2375', $computor->rawTotal());
        $this->assertSame('4.4625000000', $computor->rawDiscountWithVat());
    }
}
