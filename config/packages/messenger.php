<?php

declare(strict_types=1);

use SharedKernel\Infrastructure\Messenger\InboxMiddleware;
use SharedKernel\Infrastructure\Messenger\Message\ExternalAsyncMessageInterface;
use SharedKernel\Infrastructure\Messenger\Message\InternalAsyncMessageInterface;
use SharedKernel\Infrastructure\Messenger\Message\SyncMessageInterface;
use SharedKernel\Infrastructure\Messenger\OutboxMiddleware;
use SharedKernel\Infrastructure\Messenger\Serializer\JsonMessageSerializer;
use SharedKernel\Infrastructure\Messenger\UnlimitedRetryStrategy;
use Symfony\Config\FrameworkConfig;

// @formatter:off
return static function (FrameworkConfig $framework): void {
    $messenger = $framework->messenger();

    // Bus
    $messenger
        ->defaultBus('outbox');

    $messenger
        ->bus('outbox')
        ->middleware('doctrine_ping_connection')
        ->middleware('doctrine_transaction')
        ->middleware(OutboxMiddleware::class);

    $messenger
        ->bus('inbox')
        ->middleware('doctrine_ping_connection')
        ->middleware('doctrine_transaction')
        ->middleware(InboxMiddleware::class);

    // Transports
    $messenger
        ->transport('sync')
        ->dsn('sync://');

    $messenger
        ->transport('outbox')
        ->dsn('%env(resolve:DOCTRINE_TRANSPORT_DSN)%')
        ->serializer(JsonMessageSerializer::class)
        ->options(['table_name' => '_outbox'])
        ->failureTransport('outbox_failed')
        ->retryStrategy([
            'max_retries' => 5,
            'delay' => 1000,
            'multiplier' => 2,
            'max_delay' => 0,
        ]);

    $messenger
        ->transport('outbox_failed')
        ->dsn('%env(resolve:DOCTRINE_TRANSPORT_DSN)%')
        ->serializer(JsonMessageSerializer::class)
        ->options(['table_name' => '_outbox_failed'])
        ->retryStrategy(['service' => UnlimitedRetryStrategy::class]);

    $messenger
        ->transport('outbox_log')
        ->dsn('%env(resolve:DOCTRINE_TRANSPORT_DSN)%')
        ->serializer(JsonMessageSerializer::class)
        ->options(['table_name' => '_outbox_log']);

    $messenger
        ->transport('inbox')
        ->dsn('%env(resolve:DOCTRINE_TRANSPORT_DSN)%')
        ->serializer(JsonMessageSerializer::class)
        ->options(['table_name' => '_inbox'])
        ->failureTransport('inbox_failed')
        ->retryStrategy([
            'max_retries' => 5,
            'delay' => 1000,
            'multiplier' => 2,
            'max_delay' => 0,
        ]);

    $messenger
        ->transport('inbox_failed')
        ->dsn('%env(resolve:DOCTRINE_TRANSPORT_DSN)%')
        ->serializer(JsonMessageSerializer::class)
        ->options(['table_name' => '_inbox_failed'])
        ->retryStrategy(['service' => UnlimitedRetryStrategy::class]);

    $messenger
        ->transport('inbox_log')
        ->dsn('%env(resolve:DOCTRINE_TRANSPORT_DSN)%')
        ->serializer(JsonMessageSerializer::class)
        ->options(['table_name' => '_inbox_log']);

    // Routing
    $messenger
        ->routing(SyncMessageInterface::class)
        ->senders(['sync']);

    $messenger
        ->routing(InternalAsyncMessageInterface::class)
        ->senders(['inbox']);

    $messenger
        ->routing(ExternalAsyncMessageInterface::class)
        ->senders(['outbox']);
};
