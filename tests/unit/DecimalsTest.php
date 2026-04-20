<?php

use LaravelEnso\Helpers\Services\Decimals;
use PHPUnit\Framework\Attributes\Test;
use Tests\TestCase;

class DecimalsTest extends TestCase
{
    protected function setUp(): void
    {
        parent::setUp();

        Decimals::scale(4);
    }

    #[Test]
    public function can_update_default_scale_and_use_it_when_precision_is_not_provided()
    {
        Decimals::scale(6);

        $this->assertSame(6, Decimals::scale());
        $this->assertSame('3.580100', Decimals::add('1.2345', '2.3456'));
    }

    #[Test]
    public function can_perform_basic_arithmetic_operations()
    {
        $this->assertSame('3.5801', Decimals::add('1.2345', '2.3456'));
        $this->assertSame('1.1111', Decimals::sub('2.3456', '1.2345'));
        $this->assertSame('6.2500', Decimals::mul('2.5', '2.5'));
        $this->assertSame('2.5000', Decimals::div('10', '4'));
        $this->assertSame('3.0000', Decimals::sqrt('9'));
        $this->assertSame('15.6250', Decimals::pow('2.5', '3'));
        $this->assertSame('1.0000', Decimals::mod('10', '3'));
    }

    #[Test]
    public function can_perform_power_modulo_operations_with_an_explicit_modulus()
    {
        $this->assertSame('445.0000', Decimals::powmod('4', '13', '497'));
    }

    #[Test]
    public function can_compare_values_with_the_requested_precision()
    {
        $this->assertTrue(Decimals::eq('1.2344', '1.2345', 3));
        $this->assertTrue(Decimals::notEq('1.2344', '1.2345', 4));
        $this->assertTrue(Decimals::lt('1.2344', '1.2345', 4));
        $this->assertTrue(Decimals::lte('1.2345', '1.2345', 4));
        $this->assertTrue(Decimals::gt('1.2346', '1.2345', 4));
        $this->assertTrue(Decimals::gte('1.2345', '1.2345', 4));
    }

    #[Test]
    public function can_round_values_and_return_minimum_and_maximum()
    {
        $this->assertSame('1.24', Decimals::ceil('1.231', 2));
        $this->assertSame('1.23', Decimals::floor('1.239', 2));
        $this->assertSame('1.24', Decimals::round('1.235', 2));
        $this->assertSame('1.2344', Decimals::min('1.2344', '1.2345'));
        $this->assertSame('1.2345', Decimals::max('1.2344', '1.2345'));
    }
}
