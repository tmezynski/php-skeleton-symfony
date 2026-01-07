<?php

declare(strict_types=1);

namespace Shared\Domain\ValueObject\Uuid;

use Utils\Exception\DetailedException;
use Utils\Exception\ErrorCode;

final class InvalidUuidException extends DetailedException
{
    public function __construct(string $uuid)
    {
        parent::__construct(
            sprintf('Invalid UUID string: %s', $uuid),
            ErrorCode::InvalidUuidString,
            'You should pass valid UUID string.',
        );
    }
}
