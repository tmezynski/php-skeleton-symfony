<?php

declare(strict_types=1);

namespace Shared\Domain\Model;

use Shared\Domain\Event\AsyncEvent;
use Shared\Domain\Event\SyncEvent;

abstract class AggregateRoot
{
    /**
     * @var AsyncEvent[]|SyncEvent[]
     */
    protected array $events = [];

    protected int $version = 0;

    /**
     * @return AsyncEvent[]|SyncEvent[]
     */
    public function popEvents(): array
    {
        $events = $this->events;
        $this->events = [];

        return $events;
    }

    public function addEvent(AsyncEvent|SyncEvent $event): void
    {
        $this->events[] = $event;
    }

    public function version(): int
    {
        return $this->version;
    }
}