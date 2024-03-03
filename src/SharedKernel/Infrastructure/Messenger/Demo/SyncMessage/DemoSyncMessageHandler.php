<?php

declare(strict_types=1);

namespace SharedKernel\Infrastructure\Messenger\Demo\SyncMessage;

use Symfony\Component\Messenger\Attribute\AsMessageHandler;

#[AsMessageHandler]
final class DemoSyncMessageHandler
{
    public function __invoke(DemoSyncEvent $message): void
    {
        echo sprintf("In %s... %s = %d\n", self::class, $message->name(), $message->value());
    }
}
