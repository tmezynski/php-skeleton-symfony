<?php

declare(strict_types=1);

namespace Utils\Exception;

use Utils\Enum\EnumTrait;

enum ErrorCode: int
{
    use EnumTrait;

    case ItemNotFoundInCollection = 800;
    case SentryCheckException = 999;
    case CurrencyMismatch = 1000;
    case InvalidDecimalValue = 1001;
    case InvalidDecimalPrecisionValue = 1002;
    case DivisionByZero = 1003;
    case InvalidUuidString = 1004;
    case InvalidEnumName = 1005;

    public function httpCode(): int
    {
        return match ($this) {
            self::InvalidEnumName, self::ItemNotFoundInCollection => 404,
            default => 500,
        };
    }
}
