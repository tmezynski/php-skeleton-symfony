<?php

declare(strict_types=1);

use SharedKernel\Application\Message\AsyncMessage;
use SharedKernel\Application\Message\SyncMessage;
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
        ->routing(SyncMessage::class)
        ->senders(['db_log', 'sync']);

    $messenger
        ->routing(AsyncMessage::class)
        ->senders(['db_log', 'db']);
};
