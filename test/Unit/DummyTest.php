<?php

declare(strict_types=1);

namespace Test\Unit;

use App\Shared\Infrastructure\Clock\FixedClock;
use DateTimeImmutable;
use PHPUnit\Framework\TestCase;

final class DummyTest extends TestCase
{
    public function testDummy(): void
    {
        $date = new DateTimeImmutable('2024-01-01 12:30:00');
        $clock = new FixedClock($date);
        $this->assertEquals($date, $clock->now());
    }
}
