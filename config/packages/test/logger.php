<?php

declare(strict_types=1);

namespace Symfony\Component\DependencyInjection\Loader\Configurator;

return App::config([
    'monolog' => [
        'handlers' => [
            'terminal' => [
                'type' => null,
            ],
            'sentry' => [
                'type' => null,
            ],
        ],
    ],
]);
