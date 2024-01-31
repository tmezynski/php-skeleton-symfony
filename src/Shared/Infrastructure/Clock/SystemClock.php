<?php

declare(strict_types=1);

namespace App\Shared\Infrastructure\Clock;

use App\Shared\Domain\ClockInterface;
use DateTimeImmutable;

final class SystemClock implements ClockInterface
{
    public function now(): DateTimeImmutable
    {
        return new DateTimeImmutable();
    }
}
