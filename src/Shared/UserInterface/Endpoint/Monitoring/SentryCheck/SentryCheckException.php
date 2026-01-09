<?php

declare(strict_types=1);

namespace Shared\UserInterface\Endpoint\Monitoring\SentryCheck;

use Utils\Exception\DetailedException;
use Utils\Exception\ErrorCode;

final class SentryCheckException extends DetailedException
{
    public function __construct()
    {
        parent::__construct(
            'Sentry check exception',
            ErrorCode::SentryCheckException,
            'Sentry check exception',
        );
    }
}
