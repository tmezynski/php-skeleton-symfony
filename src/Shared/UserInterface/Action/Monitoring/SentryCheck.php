<?php

declare(strict_types=1);

namespace Shared\UserInterface\Action\Monitoring;

use Exception;
use Shared\Application\Logger\Logger;

final readonly class SentryCheck
{
    public function __construct(private Logger $logger)
    {
    }

    public function __invoke(): void
    {
        $this->logger->error('Check Sentry log error');

        throw new Exception('Check Sentry exception');
    }
}
