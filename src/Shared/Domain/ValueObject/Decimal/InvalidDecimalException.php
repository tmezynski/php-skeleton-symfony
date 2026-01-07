<?php

declare(strict_types=1);

namespace Shared\Domain\ValueObject\Decimal;

use Utils\Exception\DetailedException;
use Utils\Exception\ErrorCode;

final class InvalidDecimalException extends DetailedException
{
    public static function notValidDecimalString(string $value): self
    {
        return new self(
            sprintf('Invalid value for amount: %s', $value),
            ErrorCode::InvalidDecimalValue,
            sprintf('Can not create decimal amount from value: %s. Please pass correct value.', $value),
        );
    }

    public static function notValidPrecision(int $precision): self
    {
        return new self(
            sprintf('Invalid value for precision: %s.', $precision),
            ErrorCode::InvalidDecimalPrecisionValue,
            'Precision value should be greater than 0 and should be integer.',
        );
    }

    public static function divisionByZero(): self
    {
        return new self(
            'Division by zero',
            ErrorCode::DivisionByZero,
            'Can\'t divide value by by zero.',
        );
    }

    public static function invalidType(mixed $value): self
    {
        if (is_array($value)) {
            $value = json_encode($value);
        }

        return new self(
            sprintf('Can\'t create decimal from value: %s', $value),
            ErrorCode::InvalidDecimalValue,
            'To create decimal you must pass valid float, int or string.',
        );
    }
}
