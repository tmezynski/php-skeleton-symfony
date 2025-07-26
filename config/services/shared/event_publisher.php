<?php

declare(strict_types=1);

use Shared\Application\Command\AsyncCommand;
use Shared\Application\Command\SyncCommand;
use Shared\Application\EventPublisher\EventPublisher;
use Shared\Domain\Event\AsyncEvent as DomainAsyncEvent;
use Shared\Domain\EventStorage\EventStorage;
use Shared\Infrastructure\EventPublisher\MessengerEventPublisher;
use Symfony\Component\DependencyInjection\Loader\Configurator\ContainerConfigurator;
use Shared\Domain\Event\SyncEvent as DomainSyncEvent;

// @formatter:off
return static function (ContainerConfigurator $container): void {
    $services = $container->services();

    $services
        ->set(EventStorage::class)
        ->class(MessengerEventPublisher::class);

    $services
        ->set(EventPublisher::class)
        ->class(MessengerEventPublisher::class);

    $services
        ->set(MessengerEventPublisher::class)
        ->tag(
            'messenger.message_handler',
            [
                'handles' => DomainSyncEvent::class,
                'method' => 'publish',
                'priority' => -999,
            ],
        )
        ->tag(
            'messenger.message_handler',
            [
                'handles' => DomainAsyncEvent::class,
                'method' => 'publish',
                'priority' => -999,
            ],
        )
        ->tag(
            'messenger.message_handler',
            [
                'handles' => SyncCommand::class,
                'method' => 'publish',
                'priority' => -999,
            ],
        )
        ->tag(
            'messenger.message_handler',
            [
                'handles' => AsyncCommand::class,
                'method' => 'publish',
                'priority' => -999,
            ],
        );
};
