<?php

declare(strict_types=1);

namespace Symfony\Component\DependencyInjection\Loader\Configurator;

use Shared\Application\Command\AsyncCommand;
use Shared\Application\Command\SyncCommand;
use Shared\Application\Query\AsyncQuery;
use Shared\Application\Query\SyncQuery;
use Shared\Domain\Event\AsyncEvent;
use Shared\Domain\Event\SyncEvent;

return App::config([
    'framework' => [
        'messenger' => [
            'routing' => [
                SyncCommand::class => ['audit', 'db'],
                SyncQuery::class => ['audit', 'db'],
                SyncEvent::class => ['audit', 'db'],
                AsyncCommand::class => ['audit', 'db'],
                AsyncQuery::class => ['audit', 'db'],
                AsyncEvent::class => ['audit', 'db'],
            ],
        ],
    ],
]);
