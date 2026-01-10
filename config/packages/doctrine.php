<?php

declare(strict_types=1);

namespace Symfony\Component\DependencyInjection\Loader\Configurator;

return App::config([
    'doctrine' => [
        'dbal' => [
            'connection' => [
                'name' => 'db',
                'url' => env('DATABASE_URL')->string(),
                'driver' => env('DB_DRIVER')->string(),
                'mapping_types' => [
                    'enum' => 'string',
                ],
            ],
        ],
        'orm' => [
            'entity_manager' => [
                'name' => 'default',
                'connection' => 'db',
                'auto_mapping' => false,
            ],
        ],
    ],
]);
