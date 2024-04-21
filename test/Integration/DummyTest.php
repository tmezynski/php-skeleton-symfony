<?php

declare(strict_types=1);

namespace Integration;

use DateTimeImmutable;

final class DummyTest extends IntegrationTestCase
{
    public function testDummy(): void
    {
        $date = new DateTimeImmutable('2024-01-01 12:30:00');
        $this->clock->set($date);
        $this->assertEquals($date, $this->clock->now());
    }
}
