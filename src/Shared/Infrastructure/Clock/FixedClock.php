<?php

declare(strict_types=1);

namespace App\Shared\Infrastructure\Clock;

use App\Shared\Domain\ClockInterface;
use DateTimeImmutable;
use DateTimeInterface;

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
