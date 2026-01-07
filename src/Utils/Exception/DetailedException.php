<?php

declare(strict_types=1);

namespace Utils\Exception;

use Exception;

abstract class DetailedException extends Exception
{
    public function __construct(
        private readonly string $errorMessage,
        private readonly ErrorCode $errorCode,
        private readonly string $description,
    ) {
        parent::__construct($this->errorMessage, $errorCode->value);
    }

    public function getHttpCode(): int
    {
        return $this->errorCode->httpCode();
    }

    public function getDescription(): string
    {
        return $this->description;
    }
}
