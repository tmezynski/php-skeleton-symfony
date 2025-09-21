<?php

declare(strict_types=1);

namespace Shared\Domain\ValueObject\Uuid;

use Exception;

final class InvalidUuidException extends Exception
{
    public function __construct(string $uuid)
    {
        parent::__construct(sprintf('Invalid UUID: %s', $uuid));
    }
}
