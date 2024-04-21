<?php

declare(strict_types=1);

namespace Unit\SharedKernel\Unit\Domain;

use InvalidArgumentException;
use PHPUnit\Framework\TestCase;
use SharedKernel\Domain\Currency;
use SharedKernel\Domain\Money;

final class MoneyTest extends TestCase
{
    public function testCanNotAddDifferentCurrencies(): void
    {
        $money1 = Money::create(10, Currency::AED);
        $money2 = Money::create(10, Currency::USD);

        $this->expectException(InvalidArgumentException::class);

        $money1->add($money2);
    }

    public function testCanNotSubDifferentCurrencies(): void
    {
        $money1 = Money::create(10, Currency::AED);
        $money2 = Money::create(10, Currency::USD);

        $this->expectException(InvalidArgumentException::class);

        $money1->sub($money2);
    }

    public function testAdd(): void
    {
        $money1 = Money::create(10, Currency::USD);
        $money2 = Money::create(10, Currency::USD);

        $result = $money1->add($money2);

        $this->assertEquals('20.00', $result->amount());
        $this->assertEquals('USD', $result->currency());
    }

    public function testSub(): void
    {
        $money1 = Money::create(10, Currency::USD);
        $money2 = Money::create(10, Currency::USD);

        $result = $money1->sub($money2);

        $this->assertEquals('0.00', $result->amount());
        $this->assertEquals('USD', $result->currency());
    }

    public function testMul(): void
    {
        $money = Money::create(10.321, Currency::USD);

        $result = $money->mul(10.1234);

        $this->assertEquals('104.473488', $result->amount());
        $this->assertEquals('104.47', $result->round()->amount());
        $this->assertEquals('USD', $result->currency());
    }

    public function testDiv(): void
    {
        $money = Money::create(1440.3214444, Currency::USD);

        $result = $money->div(10.1234111);

        $this->assertEquals('142.28', $result->amount());
        $this->assertEquals('USD', $result->currency());
    }
}
