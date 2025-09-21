<?php

declare(strict_types=1);

namespace Test\Integration;

use Doctrine\DBAL\Connection;
use PHPUnit\Framework\Assert;
use Shared\Application\Clock\Clock;
use Symfony\Bundle\FrameworkBundle\Test\KernelTestCase;
use Test\Utils\TestDoubles\FixedClock;

abstract class IntegrationTestCase extends KernelTestCase
{
    protected Connection $connection;
    protected FixedClock $clock;

    public function setUp(): void
    {
        self::bootKernel();

        $connection = self::getContainer()->get('doctrine.dbal.db_connection');
        Assert::assertInstanceOf(Connection::class, $connection);
        $this->connection = $connection;

        $clock = self::getContainer()->get(Clock::class);
        Assert::assertInstanceOf(FixedClock::class, $clock);
        $this->clock = $clock;

        $this->connection->beginTransaction();
    }

    public function tearDown(): void
    {
        $this->connection->rollBack();

        parent::tearDown();
    }
}
