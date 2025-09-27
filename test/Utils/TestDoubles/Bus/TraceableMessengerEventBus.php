<?php

declare(strict_types=1);

namespace Test\Utils\TestDoubles\Bus;

use Shared\Application\Bus\EventBus;
use Shared\Domain\Event\AsyncEvent;
use Shared\Domain\Event\SyncEvent;
use Symfony\Component\Messenger\Exception\HandlerFailedException;
use Symfony\Component\Messenger\MessageBusInterface;

final class TraceableMessengerEventBus implements EventBus
{
    /**
     * @var AsyncEvent[]|SyncEvent[]
     */
    private array $events = [];

    public function __construct(private readonly MessageBusInterface $eventBus)
    {
    }

    public function dispatch(AsyncEvent|SyncEvent $event): void
    {
        try {
            $this->eventBus->dispatch($event);
            $this->events[] = $event;
        } catch (HandlerFailedException $e) {
            if (null !== $e->getPrevious()) {
                throw $e->getPrevious();
            }

            throw $e;
        }
    }

    /**
     * @return AsyncEvent[]|SyncEvent[]
     */
    public function getDispatchedMessages(): array
    {
        return $this->events;
    }
}
