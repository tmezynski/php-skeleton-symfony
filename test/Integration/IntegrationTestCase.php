<?php

declare(strict_types=1);

namespace Integration;

use Doctrine\DBAL\Connection;
use SharedKernel\Application\Clock;
use SharedKernel\Infrastructure\Clock\FixedClock;
use Symfony\Bundle\FrameworkBundle\Test\KernelTestCase;
use Webmozart\Assert\Assert;

abstract class IntegrationTestCase extends KernelTestCase
{
    protected Connection $connection;
    protected FixedClock $clock;

    public function setUp(): void
    {
        self::bootKernel();

        $connection = self::getContainer()->get('doctrine.dbal.db_connection');
        Assert::isInstanceOf($connection, Connection::class);
        $this->connection = $connection;

        $clock = self::getContainer()->get(Clock::class);
        Assert::isInstanceOf($clock, FixedClock::class);
        $this->clock = $clock;

        $this->connection->beginTransaction();
    }

    public function tearDown(): void
    {
        $this->connection->rollBack();

        parent::tearDown();
    }
}
