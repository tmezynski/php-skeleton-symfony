<?php

declare(strict_types=1);

namespace Test\Utils\Dsl;

use Doctrine\DBAL\Connection;
use Symfony\Component\DependencyInjection\ContainerInterface;
use Symfony\Component\HttpKernel\KernelInterface;
use Webmozart\Assert\Assert;

final class ContainerProxy
{
    private readonly ContainerInterface $container;
    private ?Connection $connection = null;

    public function __construct(KernelInterface $kernel)
    {
        $this->container = $kernel->getContainer();
    }

    public function connection(): Connection
    {
        if (null !== $this->connection) {
            return $this->connection;
        }

        $connection = $this->container->get('doctrine.dbal.db_connection');
        Assert::isInstanceOf($connection, Connection::class);
        $this->connection = $connection;

        return $this->connection;
    }
}
