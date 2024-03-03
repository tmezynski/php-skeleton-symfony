<?php

declare(strict_types=1);

namespace SharedKernel\Infrastructure\Messenger\Demo\InternalAsyncEvent;

use Symfony\Component\Messenger\Attribute\AsMessageHandler;

#[AsMessageHandler]
final class DemoInternalAsyncEventHandler
{
    public function __invoke(DemoInternalAsyncEvent $event): void
    {
        echo sprintf("In %s... %s = %d\n", self::class, $event->name(), $event->value());
    }
}
