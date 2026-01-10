<?php

declare(strict_types=1);

namespace Shared\Application\Command\New;

use Utils\Exception\DetailedException;
use Utils\Exception\ErrorCode;

final class NewCommandException extends DetailedException
{
    public function __construct()
    {
        parent::__construct('New command exception', ErrorCode::SentryCheckException, 'New command exception');
    }
}
