<?php

declare(strict_types=1);

namespace SharedKernel\Infrastructure\Messenger\Demo\ExternalAsyncEvent;

use SharedKernel\Domain\Uuid;

final class DemoExternalMessageInterface implements ExternalMessageInterface
{
    public function __construct(private readonly Uuid $id, private readonly string $name, private readonly int $value)
    {
    }

    public function id(): Uuid
    {
        return $this->id;
    }

    public function name(): string
    {
        return $this->name;
    }

    public function value(): int
    {
        return $this->value;
    }

    public function normalize(): array
    {
        return [
            'id' => $this->id,
            'name' => $this->name,
            'value' => $this->value,
        ];
    }
}
