<?php

use LaravelEnso\Helpers\Services\Decimals;
use LaravelEnso\Helpers\Services\Loan;
use PHPUnit\Framework\Attributes\Test;
use Tests\TestCase;

class LoanTest extends TestCase
{
    protected function setUp(): void
    {
        parent::setUp();

        Decimals::scale(4);
    }

    #[Test]
    public function computes_the_expected_monthly_rate_with_residual_value_and_administration_fee()
    {
        $loan = new Loan('100000', 12, '12', '2', '10');

        $this->assertSame('9840.0335', $loan->monthlyRate());
    }

    #[Test]
    public function computes_the_expected_monthly_rate_without_residual_value()
    {
        $loan = new Loan('25000.50', 24, '7.5', '1.2', '0');

        $this->assertSame('1137.5126', $loan->monthlyRate());
    }

    #[Test]
    public function restores_the_global_decimals_scale_after_the_calculation()
    {
        Decimals::scale(3);

        $loan = new Loan('100000', 12, '12', '2', '10');
        $loan->monthlyRate();

        $this->assertSame(3, Decimals::scale());
    }
}
