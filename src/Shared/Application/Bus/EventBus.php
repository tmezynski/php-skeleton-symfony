<?php

declare(strict_types=1);

namespace Shared\Application\Bus;

use Shared\Domain\Event\AsyncEvent;
use Shared\Domain\Event\SyncEvent;

interface EventBus
{
    public function dispatch(AsyncEvent|SyncEvent $event): void;
}
