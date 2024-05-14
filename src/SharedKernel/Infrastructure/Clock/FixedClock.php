<?php

declare(strict_types=1);

namespace SharedKernel\Infrastructure\Clock;

use DateTimeImmutable;
use SharedKernel\Application\Clock;

final class FixedClock implements Clock
{
    public function __construct(private DateTimeImmutable $now = new DateTimeImmutable())
    {
    }

    public function now(): DateTimeImmutable
    {
        return $this->now;
    }

    public function set(DateTimeImmutable $dateTime): void
    {
        $this->now = $dateTime;
    }
}
