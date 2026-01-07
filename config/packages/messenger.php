<?php

declare(strict_types=1);

use Shared\Application\Command\AsyncCommand;
use Shared\Application\Command\SyncCommand;
use Shared\Application\Query\AsyncQuery;
use Shared\Application\Query\SyncQuery;
use Shared\Domain\Event\AsyncEvent;
use Shared\Domain\Event\SyncEvent;
use Symfony\Config\FrameworkConfig;
use Utils\Messenger\UnlimitedRetryStrategy;

use function Symfony\Component\DependencyInjection\Loader\Configurator\env;

// @formatter:off
return static function (FrameworkConfig $framework): void {
    // @formatter:on
    $messenger = $framework->messenger();

    // Bus
    $messenger
        ->defaultBus('commandBus');

    $messenger
        ->bus('commandBus')
        ->middleware('doctrine_ping_connection')
        ->middleware('doctrine_transaction');

    $messenger
        ->bus('eventBus')
        ->defaultMiddleware('allow_no_handlers');

    $messenger
        ->bus('queryBus');

    // Transports
    $messenger
        ->transport('sync')
        ->dsn('sync://');

    $messenger
        ->transport('db')
        ->dsn(env('MESSENGER_DOCTRINE_TRANSPORT'))
        ->options(['table_name' => 'queues.messages', 'queue_name' => 'shared', 'auto_setup' => false])
        ->failureTransport('db_failed')
        ->retryStrategy()
        ->maxRetries(3)
        ->delay(1)
        ->multiplier(1);

    $messenger
        ->transport('db_failed')
        ->dsn(env('MESSENGER_DOCTRINE_TRANSPORT'))
        ->options(['table_name' => 'queues.messages', 'queue_name' => 'shared', 'auto_setup' => false])
        ->retryStrategy(['service' => UnlimitedRetryStrategy::class]);

    $messenger
        ->transport('audit')
        ->dsn(env('MESSENGER_DOCTRINE_TRANSPORT'))
        ->options(['table_name' => 'queues.messages_log', 'queue_name' => 'shared', 'auto_setup' => false]);

    // Routing
    $messenger
        ->routing(SyncCommand::class)
        ->senders(['audit', 'sync']);

    $messenger
        ->routing(SyncQuery::class)
        ->senders(['sync']);

    $messenger
        ->routing(SyncEvent::class)
        ->senders(['audit', 'sync']);

    $messenger
        ->routing(AsyncCommand::class)
        ->senders(['audit', 'db']);

    $messenger
        ->routing(AsyncQuery::class)
        ->senders(['audit', 'db']);

    $messenger
        ->routing(AsyncEvent::class)
        ->senders(['audit', 'db']);
};
