<?php

declare(strict_types=1);

namespace Unit\Shared\Domain;

use InvalidArgumentException;
use PHPUnit\Framework\Attributes\CoversClass;
use PHPUnit\Framework\Attributes\Test;
use PHPUnit\Framework\TestCase;
use Shared\Domain\Amount;
use Shared\Domain\Currency;
use Shared\Domain\EnumTrait;
use Shared\Domain\Money;

#[
    CoversClass(Money::class),
    CoversClass(Amount::class),
    CoversClass(Currency::class),
    CoversClass(EnumTrait::class),
]
final class MoneyTest extends TestCase
{
    #[Test]
    public function canNotAddDifferentCurrencies(): void
    {
        $usd = new Money(new Amount('1'), Currency::USD);
        $gbp = new Money(new Amount('4'), Currency::GBP);

        $this->expectException(InvalidArgumentException::class);
        $usd->add($gbp);
    }

    #[Test]
    public function addSameCurrencies(): void
    {
        $usd1 = new Money(new Amount('1'), Currency::USD);
        $usd2 = new Money(new Amount('4'), Currency::USD);

        $result = $usd1->add($usd2);

        $this->assertTrue(
            $result->equals(
                new Money(new Amount('5'), Currency::USD),
            ),
        );
        $this->assertTrue(
            $result->equalsRounded(
                new Money(new Amount('5.00'), Currency::USD),
            ),
        );
    }

    #[Test]
    public function canNotSubDifferentCurrencies(): void
    {
        $usd = new Money(new Amount('1'), Currency::USD);
        $gbp = new Money(new Amount('4'), Currency::GBP);

        $this->expectException(InvalidArgumentException::class);
        $usd->sub($gbp);
    }

    #[Test]
    public function subSameCurrencies(): void
    {
        $usd1 = new Money(new Amount('4'), Currency::USD);
        $usd2 = new Money(new Amount('3'), Currency::USD);

        $result = $usd1->sub($usd2);

        $this->assertTrue(
            $result->equals(
                new Money(new Amount('1'), Currency::USD),
            ),
        );

        $this->assertTrue(
            $result->equalsRounded(
                new Money(new Amount('1.00'), Currency::USD),
            ),
        );
    }

    #[Test]
    public function mulCurrencyByValue(): void
    {
        $usd = new Money(new Amount('4'), Currency::USD);

        $result = $usd->mul(new Amount('1.55432'));

        $this->assertTrue(
            $result->equals(
                new Money(new Amount('6.21728'), Currency::USD),
            ),
        );

        $this->assertTrue(
            $result->equalsRounded(
                new Money(new Amount('6.22'), Currency::USD),
            ),
        );
    }

    #[Test]
    public function divCurrencyByValue(): void
    {
        $usd = new Money(new Amount('4'), Currency::USD);

        $result = $usd->div(new Amount('1.55432'));

        $this->assertTrue(
            $result->equals(
                new Money(new Amount('2,57347264'), Currency::USD),
            ),
        );

        $this->assertTrue(
            $result->equalsRounded(
                new Money(new Amount('2,57'), Currency::USD),
            ),
        );
    }

    #[Test]
    public function printMoney(): void
    {
        $money = new Money(new Amount('1.33332'), Currency::USD);
        $this->assertEquals('1.33 USD', (string)$money);
    }

    #[Test]
    public function toMementoAndFromMementoShouldCreateValidObject(): void
    {
        $money = new Money(new Amount('1.33332'), Currency::USD);
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
