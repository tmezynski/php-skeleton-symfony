<?php

declare(strict_types=1);

namespace Shared\Application\Bus;

use Shared\Application\Command\AsyncCommand;
use Shared\Application\Command\SyncCommand;

interface CommandBus
{
    public function execute(AsyncCommand|SyncCommand $command): void;
}
