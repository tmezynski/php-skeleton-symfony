<?php

declare(strict_types=1);

namespace Symfony\Component\DependencyInjection\Loader\Configurator;

use Shared\Application\Command\AsyncCommand;
use Shared\Application\Command\SyncCommand;
use Shared\Application\Query\AsyncQuery;
use Shared\Application\Query\SyncQuery;
use Shared\Domain\Event\AsyncEvent;
use Shared\Domain\Event\SyncEvent;
use Utils\Messenger\UnlimitedRetryStrategy;

return App::config([
    'framework' => [
        'messenger' => [
            'default_bus' => 'commandBus',
            'buses' => [
                'commandBus' => [
                    'middleware' => ['doctrine_ping_connection', 'doctrine_transaction'],
                ],
                'eventBus' => [
                    'default_middleware' => 'allow_no_handlers',
                ],
                'queryBus' => [],
            ],
            'transports' => [
                'sync' => [
                    'dsn' => 'sync://',
                ],
                'db' => [
                    'dsn' => env('MESSENGER_DOCTRINE_TRANSPORT')->string(),
                    'options' => ['table_name' => 'queues.messages', 'queue_name' => 'shared', 'auto_setup' => false],
                    'failure_transport' => 'db_failed',
                    'serializer' => 'messenger.transport.symfony_serializer',
                    'retry_strategy' => ['max_retries' => 3, 'delay' => 1, 'multiplier' => 1],
                ],
                'db_failed' => [
                    'dsn' => env('MESSENGER_DOCTRINE_TRANSPORT')->string(),
                    'options' => [
                        'table_name' => 'queues.messages_failed',
                        'queue_name' => 'shared',
                        'auto_setup' => false,
                    ],
                    'serializer' => 'messenger.transport.symfony_serializer',
                    'retry_strategy' => ['service' => UnlimitedRetryStrategy::class],
                ],
                'audit' => [
                    'dsn' => env('MESSENGER_DOCTRINE_TRANSPORT')->string(),
                    'options' => [
                        'table_name' => 'queues.messages_log',
                        'queue_name' => 'shared',
                        'auto_setup' => false,
                    ],
                ],
            ],
            'routing' => [
                SyncCommand::class => ['audit', 'sync'],
                SyncQuery::class => ['sync'],
                SyncEvent::class => ['audit', 'sync'],
                AsyncCommand::class => ['audit', 'db'],
                AsyncQuery::class => ['audit', 'db'],
                AsyncEvent::class => ['audit', 'db'],
            ],
        ],
    ],
]);
