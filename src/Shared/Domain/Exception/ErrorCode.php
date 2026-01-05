<?php

declare(strict_types=1);

namespace Shared\Domain\Exception;

use Shared\Domain\ValueObject\Enum\EnumTrait;

enum ErrorCode: int
{
    use EnumTrait;

    case CurrencyMismatch = 1000;

    public function httpCode(): int
    {
        return match ($this) {
            default => 500,
        };
    }
}
