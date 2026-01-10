<?php

declare(strict_types=1);

namespace Symfony\Component\DependencyInjection\Loader\Configurator;

use Shared\Application\Bus\CommandBus;
use Shared\Application\Bus\EventBus;
use Shared\Application\Bus\QueryBus;
use Shared\Infrastructure\Bus\MessengerQueryBus;
use Test\Utils\TestDoubles\Bus\TraceableMessengerCommandBus;
use Test\Utils\TestDoubles\Bus\TraceableMessengerEventBus;

return App::config([
    'services' => [
        QueryBus::class => [
            'class' => MessengerQueryBus::class,
            'arguments' => ['$queryBus' => service('queryBus')],
            'public' => true,
        ],
        EventBus::class => [
            'class' => TraceableMessengerEventBus::class,
            'arguments' => ['$eventBus' => service('eventBus')],
            'public' => true,
        ],
        CommandBus::class => [
            'class' => TraceableMessengerCommandBus::class,
            'arguments' => ['$commandBus' => service('commandBus')],
            'public' => true,
        ],
    ],
]);
