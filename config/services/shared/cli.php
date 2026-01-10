<?php

declare(strict_types=1);

namespace Symfony\Component\DependencyInjection\Loader\Configurator;

use Shared\Application\Bus\CommandBus;
use Shared\UserInterface\Cli\TestCommand;

return App::config([
    'services' => [
        TestCommand::class => [
            'class' => TestCommand::class,
            'arguments' => ['$commandBus' => service(CommandBus::class)],
            'public' => true,
        ],
    ],
]);
