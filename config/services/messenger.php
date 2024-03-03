<?php

declare(strict_types=1);

namespace Symfony\Component\DependencyInjection\Loader\Configurator;

use SharedKernel\Infrastructure\Messenger\Demo\ExternalAsyncEvent\ExternalMessageSender;
use SharedKernel\Infrastructure\Messenger\Demo\ExternalAsyncEvent\SendDemoExternalAsyncEventCommand;
use SharedKernel\Infrastructure\Messenger\Demo\InternalAsyncEvent\DemoInternalAsyncEventHandler;
use SharedKernel\Infrastructure\Messenger\Demo\InternalAsyncEvent\SendDemoInternalAsyncEventCommand;
use SharedKernel\Infrastructure\Messenger\Demo\SyncMessage\DemoSyncMessageHandler;
use SharedKernel\Infrastructure\Messenger\Demo\SyncMessage\SendDemoSyncMessageCommand;
use SharedKernel\Infrastructure\Messenger\InboxMiddleware;
use SharedKernel\Infrastructure\Messenger\OutboxMiddleware;
use SharedKernel\Infrastructure\Messenger\Serializer\JsonMessageSerializer;
use SharedKernel\Infrastructure\Messenger\Serializer\Normalizer\MoneyNormalizer;
use SharedKernel\Infrastructure\Messenger\Serializer\Normalizer\UuidNormalizer;
use SharedKernel\Infrastructure\Messenger\UnlimitedRetryStrategy;
use Symfony\Component\Serializer\Encoder\JsonEncoder;
use Symfony\Component\Serializer\Normalizer\ArrayDenormalizer;
use Symfony\Component\Serializer\Normalizer\DateTimeNormalizer;
use Symfony\Component\Serializer\Normalizer\ObjectNormalizer;
use Symfony\Component\Serializer\Normalizer\PropertyNormalizer;
use Symfony\Component\Serializer\Serializer;

return static function (ContainerConfigurator $containerConfigurator): void {
    $services = $containerConfigurator->services();

    $services->defaults()
        ->autowire(false)
        ->autoconfigure();

    $services->set(UuidNormalizer::class);
    $services->set(MoneyNormalizer::class);
    $services->set(DateTimeNormalizer::class);
    $services->set(ArrayDenormalizer::class);
    $services->set(PropertyNormalizer::class);
    $services->set(ObjectNormalizer::class);
    $services->set(JsonEncoder::class);

    $services
        ->set(Serializer::class)
        ->args([
            [
                service(UuidNormalizer::class),
                service(MoneyNormalizer::class),
                service(DateTimeNormalizer::class),
                service(ArrayDenormalizer::class),
                service(PropertyNormalizer::class),
                service(ObjectNormalizer::class),
            ],
            [
                service(JsonEncoder::class),
            ],
        ]);

    $services
        ->set(JsonMessageSerializer::class)
        ->args([service(Serializer::class)]);

    $services
        ->set(UnlimitedRetryStrategy::class);

    /************************* OUTBOX **************************************/
    $services->set(OutboxMiddleware::class);

    $services
        ->set(ExternalMessageSender::class)
        ->args([
            service('redis'),
            env('APP_NAME'),
        ]);
    /************************* OUTBOX END **********************************/

    /*************************** INBOX *************************************/
    $services->set(InboxMiddleware::class);
    /*************************** INBOX END *********************************/

    /************************* OUTBOX DEMO *********************************/
    $services
        ->set(SendDemoExternalAsyncEventCommand::class)
        ->autowire()
        ->tag('console.command', ['command' => 'app:send-external-async-event'])
        ->args([service('outbox')]);

    $services
        ->set(SendDemoInternalAsyncEventCommand::class)
        ->autowire()
        ->tag('console.command', ['command' => 'app:send-internal-async-event'])
        ->args([service('outbox')]);

    $services
        ->set(SendDemoSyncMessageCommand::class)
        ->autowire()
        ->tag('console.command', ['command' => 'app:send-sync-message'])
        ->args([service('outbox')]);
    /************************* OUTBOX DEMO END *****************************/

    $services->set(ExternalMessageSender::class);
    $services->set(DemoInternalAsyncEventHandler::class);
    $services->set(DemoSyncMessageHandler::class);
};
