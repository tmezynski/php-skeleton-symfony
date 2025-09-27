<?php

declare(strict_types=1);

namespace Symfony\Component\DependencyInjection\Loader\Configurator;

use Shared\Application\Bus\CommandBus;
use Shared\Application\Bus\EventBus;
use Shared\Application\Bus\QueryBus;
use Shared\Infrastructure\Bus\MessengerCommandBus;
use Shared\Infrastructure\Bus\MessengerEventBus;
use Shared\Infrastructure\Bus\MessengerQueryBus;
use Shared\Infrastructure\Messenger\UnlimitedRetryStrategy;

return static function (ContainerConfigurator $containerConfigurator): void {
    $services = $containerConfigurator->services();

    $services->defaults()
        ->autowire()
        ->autoconfigure();

    $services
        ->set(UnlimitedRetryStrategy::class);

    $services->set(QueryBus::class, MessengerQueryBus::class)
        ->args([service('queryBus')]);

    $services->set(EventBus::class, MessengerEventBus::class)
        ->args([service('eventBus')]);

    $services->set(CommandBus::class, MessengerCommandBus::class)
        ->args([service('commandBus')]);
};
