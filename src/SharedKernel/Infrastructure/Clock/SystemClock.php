<?php

declare(strict_types=1);

namespace SharedKernel\Infrastructure\Clock;

use DateTimeImmutable;
use SharedKernel\Application\ClockInterface;

final class SystemClock implements ClockInterface
{
    public function now(): DateTimeImmutable
    {
        return new DateTimeImmutable();
    }
}
