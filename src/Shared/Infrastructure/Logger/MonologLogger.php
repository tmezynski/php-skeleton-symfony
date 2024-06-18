<?php

declare(strict_types=1);

namespace Shared\Infrastructure\Logger;

use Shared\Application\Logger\Logger;

final readonly class MonologLogger implements Logger
{
    public function __construct(private Logger $logger, private string $prefix)
    {
    }

    /**
     * @param array<string, mixed> $context
     */
    public function critical(string $message, array $context = []): void
    {
        $this->logger->critical($this->prefix . $message, $context);
    }

    /**
     * @param array<string, mixed> $context
     */
    public function info(string $message, array $context = []): void
    {
        $this->logger->info($this->prefix . $message, $context);
    }
}
