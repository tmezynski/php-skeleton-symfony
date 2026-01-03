<?php

declare(strict_types=1);

namespace Shared\Domain\ValueObject\Enum;

use Exception;

final class InvalidEnumException extends Exception
{
    public function __construct(string $caseName, string $enumClass)
    {
        parent::__construct(sprintf('%s is not a valid case for enum %s', $caseName, $enumClass));
    }
}
