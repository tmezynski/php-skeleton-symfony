<?php

declare(strict_types=1);

namespace Test\Utils\Context;

use Behat\Behat\Context\Context;
use Doctrine\DBAL\Connection;

final class DatabaseContext implements Context
{
    public function __construct(private readonly Connection $connection)
    {
    }

    /**
     * @BeforeScenario
     */
    public function beginTransaction(): void
    {
        $this->connection->beginTransaction();
    }

    /**
     * @AfterScenario
     */
    public function rollbackTransaction(): void
    {
        $this->connection->rollBack();
    }
}
