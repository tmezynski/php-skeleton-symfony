<?php

declare(strict_types=1);

namespace Test\Utils\Context;

use Behat\Behat\Context\Context;
use DateTimeImmutable;
use RuntimeException;
use Shared\Application\Clock\Clock;
use Shared\Infrastructure\Clock\FixedClock;

final class TimeContext implements Context
{
    public function __construct(private readonly Clock $clock)
    {
    }

    /**
     * @Given The time is :dateTime
     */
    public function theTimeIsGiven(string $dateTime): void
    {
        if (!$this->clock instanceof FixedClock) {
            throw new RuntimeException('Clock must be an instance of FixedClock');
        }

        $this->clock->set(new DateTimeImmutable($dateTime));
    }
}
