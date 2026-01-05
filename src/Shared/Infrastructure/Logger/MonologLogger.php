<?php

declare(strict_types=1);

namespace Shared\Infrastructure\Logger;

use Psr\Log\LoggerInterface;
use Shared\Application\Logger\Logger;

final readonly class MonologLogger implements Logger
{
    public function __construct(private LoggerInterface $logger)
    {
    }

    /**
     * @param array<string, mixed> $context
     */
    public function debug(string $message, array $context = []): void
    {
        $this->logger->debug($message, $context);
    }

    /**
     * @param array<string, mixed> $context
     */
    public function info(string $message, array $context = []): void
    {
        $this->logger->info($message, $context);
    }

    /**
     * @param array<string, mixed> $context
     */
    public function notice(string $message, array $context = []): void
    {
        $this->logger->notice($message, $context);
    }

    /**
     * @param array<string, mixed> $context
     */
    public function warning(string $message, array $context = []): void
    {
        $this->logger->warning($message, $context);
    }

    /**
     * @param array<string, mixed> $context
     */
    public function error(string $message, array $context = []): void
    {
        $this->logger->error($message, $context);
    }

    /**
     * @param array<string, mixed> $context
     */
    public function alert(string $message, array $context = []): void
    {
        $this->logger->alert($message, $context);
    }

    /**
     * @param array<string, mixed> $context
     */
    public function emergency(string $message, array $context = []): void
    {
        $this->logger->emergency($message, $context);
    }

    /**
     * @param array<string, mixed> $context
     */
    public function critical(string $message, array $context = []): void
    {
        $this->logger->critical($message, $context);
    }
}
