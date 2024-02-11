<?php

declare(strict_types=1);

namespace SharedKernel\Infrastructure\Clock;

use DateTimeImmutable;
use DateTimeInterface;
use SharedKernel\Application\ClockInterface;

final class FixedClock implements ClockInterface
{
    public function __construct(private DateTimeInterface $now = new DateTimeImmutable())
    {
    }

    public function now(): DateTimeInterface
    {
        return $this->now;
    }

    public function travelTo(DateTimeInterface $dateTime): void
    {
        $this->now = $dateTime;
    }
}
