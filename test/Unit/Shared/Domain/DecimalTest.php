<?php

declare(strict_types=1);

namespace Test\Unit\Shared\Domain;

use Generator;
use PHPUnit\Framework\Assert;
use PHPUnit\Framework\Attributes\DataProvider;
use PHPUnit\Framework\Attributes\Test;
use PHPUnit\Framework\TestCase;
use Shared\Domain\ValueObject\Decimal\Decimal;
use Shared\Domain\ValueObject\Decimal\InvalidDecimalException;
use Throwable;

final class DecimalTest extends TestCase
{
    #[Test]
    public function canNotCreateDecimalFromInvalidString(): void
    {
        $this->expectException(InvalidDecimalException::class);

        Decimal::from('abc');
    }

    #[Test]
    public function canNotCreateDecimalFromInvalidValue(): void
    {
        $this->expectException(InvalidDecimalException::class);

        Decimal::from([1]);
    }

    #[Test]
    #[DataProvider('validDecimalDataProvider')]
    public function canCreateDecimalFromValue(float|int|string $value, string $result): void
    {
        Assert::assertEquals($result, Decimal::from($value)->toString());
    }

    public static function validDecimalDataProvider(): Generator
    {
        yield ['-145,00', '-145.00'];

        yield ['-145.00', '-145.00'];

        yield ['-100', '-100'];

        yield ['-0.8', '-0.8'];

        yield ['-0.008', '-0.008'];

        yield ['-0', '0'];

        yield ['0', '0'];

        yield ['1223', '1223'];

        yield ['1223.9456', '1223.9456'];

        yield ['1223,9456', '1223.9456'];

        yield [-145.00, '-145'];

        yield [-100, '-100'];

        yield [-0.8, '-0.8'];

        yield [-0.008, '-0.008'];

        yield [-0, '0'];

        yield [0, '0'];

        yield [1223, '1223'];

        yield [1223.9456, '1223.9456'];
    }

    #[Test]
    #[DataProvider('addValuesDataProvider')]
    public function addShouldReturnValidResult(string $value1, string $value2, string $result): void
    {
        $amount1 = Decimal::from($value1);
        $amount2 = Decimal::from($value2);
        $result = Decimal::from($result);

        Assert::assertTrue($result->equals($amount1->add($amount2)));
        Assert::assertTrue($result->equals($amount2->add($amount1)));
    }

    public static function addValuesDataProvider(): Generator
    {
        yield ['-145,00', '-145.00', '-290.00'];

        yield ['-145,01', '-145.0000', '-290.0100'];

        yield ['-145,01', '145.0000', '-0.0100'];

        yield ['-145', '145', '0'];

        yield ['0', '145', '145'];

        yield ['0.34567', '100', '100.34567'];
    }

    #[Test]
    #[DataProvider('subValuesDataProvider')]
    public function subShouldReturnValidResult(string $value1, string $value2, string $result): void
    {
        $amount1 = Decimal::from($value1);
        $amount2 = Decimal::from($value2);
        $result = Decimal::from($result);

        Assert::assertTrue($result->equals($amount1->sub($amount2)));
    }

    public static function subValuesDataProvider(): Generator
    {
        yield ['-145,00', '-145.00', '0.00'];

        yield ['-145,01', '-145.0000', '-0.0100'];

        yield ['-145,01', '145.0000', '-290.0100'];

        yield ['-145', '145', '-290'];

        yield ['0', '145', '-145'];

        yield ['0.34567', '100', '-99.65433'];

        yield ['100.34567', '10.34567', '90.00000'];

        yield ['8', '6.4', '1.6'];
    }

    #[Test]
    #[DataProvider('mulValuesDataProvider')]
    public function mulShouldReturnValidResult(string $value1, string $value2, string $result): void
    {
        $amount1 = Decimal::from($value1);
        $amount2 = Decimal::from($value2);
        $result = Decimal::from($result);

        Assert::assertTrue($result->equals($amount1->mul($amount2)));
    }

    public static function mulValuesDataProvider(): Generator
    {
        yield ['-145,00', '-145.00', '21025,00'];

        yield ['-145,01', '-145.0000', '21026,4500'];

        yield ['0', '145', '0'];

        yield ['0.34567', '100', '34.567'];

        yield ['100.34567', '10.34567', '1038.14318774'];
    }

    #[Test]
    public function canNotDivideByZero(): void
    {
        $zero = Decimal::from('0');

        try {
            $result = $zero->div($zero);
        } catch (Throwable) {
        }

        Assert::assertFalse(isset($result));
    }

    #[Test]
    #[DataProvider('divValuesDataProvider')]
    public function divShouldReturnValidResult(string $value1, string $value2, string $result): void
    {
        $amount1 = Decimal::from($value1);
        $amount2 = Decimal::from($value2);
        $result = Decimal::from($result);

        Assert::assertTrue($result->equals($amount1->div($amount2)));
    }

    public static function divValuesDataProvider(): Generator
    {
        yield ['100', '-2', '-50'];

        yield ['-100', '-2', '50'];

        yield ['1', '2', '0.5'];

        yield ['0', '10', '0'];

        yield ['-2', '10', '-0.2'];

        yield ['-2', '-4', '0.5'];
    }

    #[Test]
    public function canNotRoundToNegativeFraction(): void
    {
        $this->expectException(InvalidDecimalException::class);
        Decimal::from('1')->round(-1);
    }

    #[Test]
    #[DataProvider('roundDataProvider')]
    public function roundToPassedPrecision(string $value, int $precision, string $result): void
    {
        $this->assertEquals(
            $result,
            Decimal::from($value)->round($precision)->toString(),
        );
    }

    public static function roundDataProvider(): Generator
    {
        yield ['1', 1, '1'];

        yield ['1', 4, '1'];

        yield ['1.333', 3, '1.333'];

        yield ['1.3333', 2, '1.33'];

        yield ['1.3366', 2, '1.34'];
    }
}
