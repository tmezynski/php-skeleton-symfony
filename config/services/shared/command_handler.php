<?php

declare(strict_types=1);

namespace Symfony\Component\DependencyInjection\Loader\Configurator;

use Shared\Application\Command\New\NewCommandHandler;

return App::config([
    'services' => [
        NewCommandHandler::class => [
            'class' => NewCommandHandler::class,
            'tags' => [
                ['messenger.message_handler' => ['bus' => 'commandBus']],
            ],
        ],
    ],
]);
