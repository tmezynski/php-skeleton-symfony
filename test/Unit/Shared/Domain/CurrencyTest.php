<?php

declare(strict_types=1);

namespace Test\Unit\Shared\Domain;

use PHPUnit\Framework\Assert;
use PHPUnit\Framework\Attributes\Test;
use PHPUnit\Framework\TestCase;
use Shared\Domain\ValueObject\Currency;
use ValueError;

final class CurrencyTest extends TestCase
{
    #[Test]
    public function canCreateCurrencyFromName(): void
    {
        $currency = Currency::fromName('USD');

        Assert::assertEquals(Currency::USD, $currency);
    }

    #[Test]
    public function cannotCreateCurrencyFromInvalidNameWithHardCheck(): void
    {
        $this->expectException(ValueError::class);
        Currency::fromName('ABC');
    }

    #[Test]
    public function cannotCreateCurrencyFromInvalidNameWithSoftCheck(): void
    {
        $currency = Currency::tryFromName('ABC');

        Assert::assertNull($currency);
    }
}
