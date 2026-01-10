<?php

declare(strict_types=1);

namespace Symfony\Component\DependencyInjection\Loader\Configurator;

use Shared\Application\Logger\Logger;
use Shared\UserInterface\Endpoint\Monitoring\SentryCheck\SentryCheck;
use Utils\ErrorController\ErrorController;

return App::config([
    'services' => [
        ErrorController::class => [
            'class' => ErrorController::class,
            'arguments' => [
                '$environment' => env('APP_ENV'),
            ],
            'public' => true,
        ],
        SentryCheck::class => [
            'class' => SentryCheck::class,
            'arguments' => [
                '$logger' => service(Logger::class),
            ],
            'public' => true,
        ],
    ],
]);
