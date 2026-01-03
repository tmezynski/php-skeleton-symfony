<?php

declare(strict_types=1);

namespace Test\Unit\Shared\Domain\ValueObject;

use PHPUnit\Framework\Attributes\Test;
use PHPUnit\Framework\TestCase;
use Shared\Domain\ValueObject\Currency;
use Shared\Domain\ValueObject\Decimal\Decimal;
use Shared\Domain\ValueObject\Money\DifferentCurrencyException;
use Shared\Domain\ValueObject\Money\Money;

final class MoneyTest extends TestCase
{
    #[Test]
    public function canNotAddDifferentCurrencies(): void
    {
        $usd = new Money(Decimal::from('1'), Currency::USD);
        $gbp = new Money(Decimal::from('4'), Currency::GBP);

        $this->expectException(DifferentCurrencyException::class);
        $usd->add($gbp);
    }

    #[Test]
    public function addSameCurrencies(): void
    {
        $usd1 = new Money(Decimal::from('1'), Currency::USD);
        $usd2 = new Money(Decimal::from('4'), Currency::USD);

        $result = $usd1->add($usd2);

        $this->assertTrue(
            $result->equals(
                new Money(Decimal::from('5'), Currency::USD),
            ),
        );
        $this->assertTrue(
            $result->equalsRounded(
                new Money(Decimal::from('5.00'), Currency::USD),
            ),
        );
    }

    #[Test]
    public function canNotSubDifferentCurrencies(): void
    {
        $usd = new Money(Decimal::from('1'), Currency::USD);
        $gbp = new Money(Decimal::from('4'), Currency::GBP);

        $this->expectException(DifferentCurrencyException::class);
        $usd->sub($gbp);
    }

    #[Test]
    public function subSameCurrencies(): void
    {
        $usd1 = new Money(Decimal::from('4'), Currency::USD);
        $usd2 = new Money(Decimal::from('3'), Currency::USD);

        $result = $usd1->sub($usd2);

        $this->assertTrue(
            $result->equals(
                new Money(Decimal::from('1'), Currency::USD),
            ),
        );

        $this->assertTrue(
            $result->equalsRounded(
                new Money(Decimal::from('1.00'), Currency::USD),
            ),
        );
    }

    #[Test]
    public function mulCurrencyByValue(): void
    {
        $usd = new Money(Decimal::from('4'), Currency::USD);

        $result = $usd->mul(Decimal::from('1.55432'));

        $this->assertTrue(
            $result->equals(
                new Money(Decimal::from('6.21728'), Currency::USD),
            ),
        );

        $this->assertTrue(
            $result->equalsRounded(
                new Money(Decimal::from('6.22'), Currency::USD),
            ),
        );
    }

    #[Test]
    public function divCurrencyByValue(): void
    {
        $usd = new Money(Decimal::from('4'), Currency::USD);

        $result = $usd->div(Decimal::from('1.55432'));

        $this->assertTrue(
            $result->equals(
                new Money(Decimal::from('2,57347264'), Currency::USD),
            ),
        );

        $this->assertTrue(
            $result->equalsRounded(
                new Money(Decimal::from('2,57'), Currency::USD),
            ),
        );
    }

    #[Test]
    public function printMoney(): void
    {
        $money = new Money(Decimal::from('1.33332'), Currency::USD);
        $this->assertEquals('1.33 USD', $money->toString());
    }

    #[Test]
    public function toMementoAndFromMementoShouldCreateValidObject(): void
    {
        $money = new Money(Decimal::from('1.33332'), Currency::USD);
        $this->assertEquals(
            [
                'amount' => '1.33332',
                'currency' => 'USD',
            ],
            $money->toMemento(),
        );

        $this->assertEquals(
            $money,
            Money::fromMemento(
                [
                    'amount' => '1.33332',
                    'currency' => 'USD',
                ],
            ),
        );
    }
}
