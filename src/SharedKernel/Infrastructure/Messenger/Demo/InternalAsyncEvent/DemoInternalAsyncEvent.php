<?php

declare(strict_types=1);

namespace SharedKernel\Infrastructure\Messenger\Demo\InternalAsyncEvent;

use SharedKernel\Infrastructure\Messenger\Message\InternalAsyncMessageInterface;

final class DemoInternalAsyncEvent implements InternalAsyncMessageInterface
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
