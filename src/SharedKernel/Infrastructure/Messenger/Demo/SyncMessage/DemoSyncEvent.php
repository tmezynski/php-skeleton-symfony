<?php

declare(strict_types=1);

namespace SharedKernel\Infrastructure\Messenger\Demo\SyncMessage;

use SharedKernel\Infrastructure\Messenger\Message\SyncMessageInterface;

final class DemoSyncEvent implements SyncMessageInterface
{
    public function __construct(private readonly string $name, private readonly int $value)
    {
    }

    public function name(): string
    {
        return $this->name;
    }

    public function value(): int
    {
        return $this->value;
    }
}
