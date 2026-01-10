<?php

declare(strict_types=1);

namespace Symfony\Component\DependencyInjection\Loader\Configurator;

use Sentry\Exception\FatalErrorException;

return App::config([
    'sentry' => [
        'dsn' => env('SENTRY_DSN')->string(),
        'options' => [
            'ignore_exceptions' => [
                FatalErrorException::class,
            ],
        ],
        'messenger' => [
            'capture_soft_fails' => false,
        ],
    ],
]);
