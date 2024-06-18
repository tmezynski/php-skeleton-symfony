<?php

declare(strict_types=1);

namespace Shared\Application\Logger;

interface Logger
{
    /**
     * @param array<string, mixed> $context
     */
    public function critical(string $message, array $context = []): void;

    /**
     * @param array<string, mixed> $context
     */
    public function info(string $message, array $context = []): void;
}
