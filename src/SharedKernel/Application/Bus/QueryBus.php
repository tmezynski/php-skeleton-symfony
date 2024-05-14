<?php

declare(strict_types=1);

namespace SharedKernel\Application\Bus;

use SharedKernel\Application\Query\AsyncQuery;
use SharedKernel\Application\Query\QueryResult;
use SharedKernel\Application\Query\SyncQuery;

interface QueryBus
{
    public function execute(AsyncQuery|SyncQuery $query): QueryResult;
}
