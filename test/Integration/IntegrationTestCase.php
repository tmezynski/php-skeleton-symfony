<?php

declare(strict_types=1);

namespace Test\Integration;

use Symfony\Bundle\FrameworkBundle\Test\KernelTestCase;
use Test\Utils\Dsl\ContainerProxy;

abstract class IntegrationTestCase extends KernelTestCase
{
    protected ContainerProxy $container;

    public function setUp(): void
    {
        parent::setUp();

        self::bootKernel();

        /** @var ContainerProxy $containerProxy */
        $containerProxy = self::getContainer()->get(ContainerProxy::class);
        $this->container = $containerProxy;

        $this->container->connection()->beginTransaction();
    }

    public function tearDown(): void
    {
        $this->container->connection()->rollBack();

        parent::tearDown();
    }
}
