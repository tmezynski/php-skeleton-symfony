<?php

declare(strict_types=1);

namespace Symfony\Component\DependencyInjection\Loader\Configurator;

use Shared\Application\Bus\CommandBus;
use Shared\Application\Bus\EventBus;
use Shared\Application\Bus\QueryBus;
use Shared\Infrastructure\Bus\MessengerCommandBus;
use Shared\Infrastructure\Bus\MessengerEventBus;
use Shared\Infrastructure\Bus\MessengerQueryBus;
use Utils\Messenger\UnlimitedRetryStrategy;

return App::config([
    'services' => [
        '_defaults' => [
            'autowire' => true,
            'autoconfigure' => true,
        ],
        UnlimitedRetryStrategy::class => [],
        QueryBus::class => [
            'class' => MessengerQueryBus::class,
            'arguments' => ['$queryBus' => service('queryBus')],
        ],
        EventBus::class => [
            'class' => MessengerEventBus::class,
            'arguments' => ['$eventBus' => service('eventBus')],
        ],
        CommandBus::class => [
            'class' => MessengerCommandBus::class,
            'arguments' => ['$messageBus' => service('commandBus')],
        ],
    ],
]);
