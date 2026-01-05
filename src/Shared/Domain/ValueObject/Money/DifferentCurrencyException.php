<?php

declare(strict_types=1);

namespace Shared\Domain\ValueObject\Money;

use Shared\Domain\Exception\DetailedException;
use Shared\Domain\Exception\ErrorCode;

final class DifferentCurrencyException extends DetailedException
{
    public function __construct(string $expected, string $current)
    {
        parent::__construct(
            sprintf('Currencies are different. Expected %s but got %s.', $expected, $current),
            ErrorCode::CurrencyMismatch,
            'Can not make operation on different currencies. Please pass same currencies and try again.',
        );
    }
}
