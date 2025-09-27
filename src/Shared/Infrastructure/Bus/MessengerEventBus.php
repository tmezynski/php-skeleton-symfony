<?php

declare(strict_types=1);

namespace Shared\Infrastructure\Bus;

use Shared\Application\Bus\EventBus;
use Shared\Domain\Event\AsyncEvent;
use Shared\Domain\Event\SyncEvent;
use Symfony\Component\Messenger\MessageBusInterface;

final readonly class MessengerEventBus implements EventBus
{
    public function __construct(private MessageBusInterface $eventBus)
    {
    }

    public function dispatch(AsyncEvent|SyncEvent $event): void
    {
        $this->eventBus->dispatch($event);
    }
}
