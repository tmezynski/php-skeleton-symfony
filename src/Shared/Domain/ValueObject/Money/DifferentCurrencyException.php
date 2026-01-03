<?php

declare(strict_types=1);

namespace Shared\Domain\ValueObject\Money;

use Exception;

final class DifferentCurrencyException extends Exception
{
    public function __construct(string $expected, string $get)
    {
        parent::__construct(sprintf('Currencies are different. Expected %s but got %s.', $expected, $get));
    }
}
