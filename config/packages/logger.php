<?php

declare(strict_types=1);

namespace Symfony\Component\DependencyInjection\Loader\Configurator;

use Psr\Log\LogLevel;

return App::config([
    'monolog' => [
        'handlers' => [
            'sentry' => [
                'type' => 'sentry',
                'dsn' => env('SENTRY_DSN')->string(),
                'level' => LogLevel::ERROR,
                'priority' => 0,
                'channels' => ['elements' => ['!event', '!doctrine']],
            ],
            'terminal' => [
                'type' => 'stream',
                'process_psr_3_messages' => true,
                'path' => 'php://stderr',
                'level' => LogLevel::WARNING,
                'priority' => 1,
                'channels' => ['elements' => ['!event', '!doctrine']],
            ],
        ],
    ],
]);
