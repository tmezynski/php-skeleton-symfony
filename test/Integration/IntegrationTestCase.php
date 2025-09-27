<?php

declare(strict_types=1);

namespace Test\Integration;

use Doctrine\DBAL\Connection;
use PHPUnit\Framework\Assert;
use Shared\Application\Clock\Clock;
use Symfony\Bundle\FrameworkBundle\Test\KernelTestCase;
use Symfony\Component\DependencyInjection\ContainerInterface;
use Symfony\Component\HttpKernel\KernelInterface;
use Test\Utils\TestDoubles\Clock\FixedClock;

abstract class IntegrationTestCase extends KernelTestCase
{
    protected KernelInterface $app;
    protected ContainerInterface $container;
    protected Connection $connection;
    protected FixedClock $clock;

    public function setUp(): void
    {
        $this->app ??= self::bootKernel();
        $this->container = self::getContainer();

        $connection = $this->container->get('doctrine.dbal.db_connection');
        Assert::assertInstanceOf(Connection::class, $connection);
        $this->connection = $connection;

        $clock = $this->container->get(Clock::class);
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
