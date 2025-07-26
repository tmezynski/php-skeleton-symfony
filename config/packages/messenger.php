<?php

declare(strict_types=1);

use Shared\Application\Command\AsyncCommand;
use Shared\Application\Command\SyncCommand;
use Shared\Application\Query\AsyncQuery;
use Shared\Application\Query\SyncQuery;
use Shared\Domain\Event\AsyncEvent;
use Shared\Domain\Event\SyncEvent;
use Shared\Infrastructure\Messenger\UnlimitedRetryStrategy;
use Symfony\Config\FrameworkConfig;

// @formatter:off
return static function (FrameworkConfig $framework): void {
    $messenger = $framework->messenger();

    // Bus
    $messenger
        ->defaultBus('bus');

    $messenger
        ->bus('bus')
        ->middleware('doctrine_ping_connection')
        ->middleware('doctrine_transaction');

    // Transports
    $messenger
        ->transport('sync')
        ->dsn('sync://');

    $messenger
        ->transport('db')
        ->dsn('%env(resolve:DOCTRINE_TRANSPORT_DSN)%')
        ->options(['table_name' => 'queues.messages'])
        ->retryStrategy(['service' => UnlimitedRetryStrategy::class]);

    $messenger
        ->transport('db_log')
        ->dsn('%env(resolve:DOCTRINE_TRANSPORT_DSN)%')
        ->options(['table_name' => 'queues.messages_log']);

    // Routing
    $messenger
        ->routing(SyncCommand::class)
        ->senders(['db_log', 'sync']);

    $messenger
        ->routing(SyncQuery::class)
        ->senders(['db_log', 'sync']);

    $messenger
        ->routing(SyncEvent::class)
        ->senders(['db_log', 'sync']);

    $messenger
        ->routing(AsyncCommand::class)
        ->senders(['db_log', 'sync']);

    $messenger
        ->routing(AsyncQuery::class)
        ->senders(['db_log', 'sync']);

    $messenger
        ->routing(AsyncEvent::class)
        ->senders(['db_log', 'sync']);
};
