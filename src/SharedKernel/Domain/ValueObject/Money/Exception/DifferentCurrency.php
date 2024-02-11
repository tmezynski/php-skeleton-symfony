<?php

declare(strict_types=1);

namespace SharedKernel\Domain\ValueObject\Money\Exception;

use SharedKernel\Domain\ValueObject\Currency;
use Exception;

final class DifferentCurrency extends Exception
{
    public function __construct(Currency $expected, Currency $given)
    {
        parent::__construct(
            sprintf('Expected currency %s, got %s', $expected->name, $given->name)
        );
    }
}
