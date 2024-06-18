<?php

declare(strict_types=1);

namespace Shared\Infrastructure\EventPublisher;

use Shared\Application\EventPublisher\EventPublisher;
use Shared\Domain\Event\AsyncEvent;
use Shared\Domain\Event\SyncEvent;
use Shared\Domain\EventStorage\EventStorage;
use Symfony\Component\Messenger\MessageBusInterface;

final class MessengerEventPublisher implements EventStorage, EventPublisher
{
    /**
     * @var AsyncEvent[]|SyncEvent[]
     */
    private array $events = [];

    public function __construct(private readonly MessageBusInterface $bus)
    {
    }

    public function add(AsyncEvent|SyncEvent $event): void
    {
        $this->events[] = $event;
    }

    public function publish(): void
    {
        while ($event = array_shift($this->events)) {
            $this->bus->dispatch($event);
        }
    }
}
