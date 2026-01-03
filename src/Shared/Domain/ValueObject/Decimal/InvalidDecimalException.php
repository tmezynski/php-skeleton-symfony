<?php

declare(strict_types=1);

namespace Shared\Domain\ValueObject\Decimal;

use Exception;

final class InvalidDecimalException extends Exception
{
    private function __construct(string $message)
    {
        parent::__construct($message);
    }

    public static function notValidDecimalString(string $value): self
    {
        return new self(sprintf('Invalid value for amount: %s', $value));
    }

    public static function notValidPrecision(int $precision): self
    {
        return new self(sprintf('Invalid value for precision: %s. Should be greater than 0.', $precision));
    }

    public static function divisionByZero(): self
    {
        return new self('Division by zero');
    }

    public static function invalidType(): self
    {
        return new self('Value should be float,integer or string');
    }
}
