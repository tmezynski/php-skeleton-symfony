<?php

declare(strict_types=1);

namespace Shared\Application\Bus;

use Shared\Application\Query\AsyncQuery;
use Shared\Application\Query\SyncQuery;

interface QueryBus
{
    public function execute(AsyncQuery|SyncQuery $query): QueryResult;
}
