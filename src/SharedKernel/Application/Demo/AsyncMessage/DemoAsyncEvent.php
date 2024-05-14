<?php

declare(strict_types=1);

namespace SharedKernel\Application\Demo\AsyncMessage;

use SharedKernel\Application\Message\AbstractTraceableMessage;
use SharedKernel\Application\Message\AsyncMessage;

final class DemoAsyncEvent extends AbstractTraceableMessage implements AsyncMessage
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
