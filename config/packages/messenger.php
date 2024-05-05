<?php

declare(strict_types=1);

use SharedKernel\Application\Message\AsyncMessageInterface;
use SharedKernel\Application\Message\SyncMessageInterface;
use SharedKernel\Infrastructure\Messenger\MessageSerializer;
use SharedKernel\Infrastructure\Messenger\UnlimitedRetryStrategy;
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
        ->serializer(MessageSerializer::class)
        ->options(['table_name' => 'queues.messages'])
        ->retryStrategy(['service' => UnlimitedRetryStrategy::class]);

    $messenger
        ->transport('db_log')
        ->dsn('%env(resolve:DOCTRINE_TRANSPORT_DSN)%')
        ->serializer(MessageSerializer::class)
        ->options(['table_name' => 'queues.messages_log']);

    // Routing
    $messenger
        ->routing(SyncMessageInterface::class)
        ->senders(['db_log', 'sync']);

    $messenger
        ->routing(AsyncMessageInterface::class)
        ->senders(['db_log', 'db']);
};
