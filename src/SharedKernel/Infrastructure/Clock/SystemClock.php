<?php

declare(strict_types=1);

namespace SharedKernel\Infrastructure\Clock;

use DateTimeImmutable;
use SharedKernel\Application\Clock;

final class SystemClock implements Clock
{
    public function now(): DateTimeImmutable
    {
        return new DateTimeImmutable();
    }
}
