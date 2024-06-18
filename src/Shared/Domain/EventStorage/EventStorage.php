<?php

declare(strict_types=1);

namespace Shared\Domain\EventStorage;

use Shared\Domain\Event\AsyncEvent;
use Shared\Domain\Event\SyncEvent;

interface EventStorage
{
    public function add(AsyncEvent|SyncEvent $event): void;
}
