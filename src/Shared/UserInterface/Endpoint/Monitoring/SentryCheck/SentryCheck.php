<?php

declare(strict_types=1);

namespace Shared\UserInterface\Endpoint\Monitoring\SentryCheck;

use Shared\Application\Logger\Logger;

final readonly class SentryCheck
{
    public function __construct(private Logger $logger)
    {
    }

    public function __invoke(): void
    {
        $this->logger->error('Check Sentry log error');

        throw new SentryCheckException();
    }
}
