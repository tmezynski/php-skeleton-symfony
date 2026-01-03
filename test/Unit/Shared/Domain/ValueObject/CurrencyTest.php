<?php

declare(strict_types=1);

namespace Test\Unit\Shared\Domain\ValueObject;

use PHPUnit\Framework\Assert;
use PHPUnit\Framework\Attributes\Test;
use PHPUnit\Framework\TestCase;
use Shared\Domain\ValueObject\Currency;
use Shared\Domain\ValueObject\Enum\InvalidEnumException;

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
        $this->expectException(InvalidEnumException::class);
        Currency::fromName('ABC');
    }

    #[Test]
    public function cannotCreateCurrencyFromInvalidNameWithSoftCheck(): void
    {
        $currency = Currency::tryFromName('ABC');

        Assert::assertNull($currency);
    }
}
