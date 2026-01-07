<?php

declare(strict_types=1);

namespace Utils\Enum;

use Utils\Exception\DetailedException;
use Utils\Exception\ErrorCode;

final class InvalidEnumException extends DetailedException
{
    public function __construct(string $caseName, string $enumClass)
    {
        parent::__construct(
            'Enum not found',
            ErrorCode::InvalidEnumName,
            sprintf('%s is not a valid case for enum %s', $caseName, $enumClass),
        );
    }
}
