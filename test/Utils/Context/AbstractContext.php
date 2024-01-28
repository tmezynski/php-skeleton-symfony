<?php

declare(strict_types=1);

namespace Test\Utils\Context;

use Behat\Behat\Context\Context;
use Symfony\Component\HttpKernel\KernelInterface;
use Test\Utils\Dsl\ContainerProxy;

abstract class AbstractContext implements Context
{
    protected KernelInterface $kernel;
    protected ContainerProxy $container;

    public function setUp(KernelInterface $kernel): void
    {
        $this->kernel = $kernel;

        /** @var ContainerProxy $container */
        $container = $kernel->getContainer()->get(ContainerProxy::class);
        $this->container = $container;
    }

    /**
     * @BeforeScenario
     */
    public function beginTransaction(): void
    {
        $this->container->connection()->beginTransaction();
    }

    /**
     * @AfterScenario
     */
    public function rollbackTransaction(): void
    {
        $this->container->connection()->rollBack();
    }
}
