<?php

declare(strict_types=1);

namespace Symfony\Component\DependencyInjection\Loader\Configurator;

use Shared\Application\Bus\CommandBus;
use Shared\Application\Bus\EventBus;
use Shared\Application\Bus\QueryBus;
use Shared\Infrastructure\Bus\MessengerQueryBus;
use Test\Utils\TestDoubles\Bus\TraceableMessengerCommandBus;
use Test\Utils\TestDoubles\Bus\TraceableMessengerEventBus;

return static function (ContainerConfigurator $containerConfigurator): void {
    $services = $containerConfigurator->services();

    $services->defaults()
        ->autowire()
        ->autoconfigure();

    $services->set(MessengerQueryBus::class)
        ->args([service('queryBus')])
        ->public();

    $services->set(TraceableMessengerEventBus::class)
        ->args([service('eventBus')])
        ->public();

    $services->set(TraceableMessengerCommandBus::class)
        ->args([service('commandBus')])
        ->public();

    $services->alias(EventBus::class, TraceableMessengerEventBus::class);
    $services->alias(QueryBus::class, MessengerQueryBus::class);
    $services->alias(CommandBus::class, TraceableMessengerCommandBus::class);
};
