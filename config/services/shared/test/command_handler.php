<?php

declare(strict_types=1);

namespace Symfony\Component\DependencyInjection\Loader\Configurator;

use Shared\Application\Bus\EventBus;
use Test\Integration\Shared\Application\Command\FakeCommandHandler;

return App::config([
    'services' => [
        FakeCommandHandler::class => [
            'class' => FakeCommandHandler::class,
            'arguments' => ['$eventBus' => service(EventBus::class)],
            'tags' => [
                ['messenger.message_handler' => ['bus' => 'commandBus']],
            ],
        ],
    ],
]);
