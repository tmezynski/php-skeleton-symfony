<?php

declare(strict_types=1);

namespace Symfony\Component\DependencyInjection\Loader\Configurator;

return App::config([
    'doctrine_migrations' => [
        'migrations_paths' => [
            'Shared\Infrastructure\Migration\PostgreSql' => '%kernel.project_dir%/src/Shared/Infrastructure/Migration/PostgreSql',
        ],
        'storage' => [
            'table_storage' => [
                'table_name' => 'migrations',
                'version_column_name' => 'version',
                'executed_at_column_name' => 'executed_at',
                'execution_time_column_name' => 'execution_time',
                'version_column_length' => 191,
            ],
        ],
        'all_or_nothing' => true,
        'transactional' => true,
        'check_database_platform' => true,
        'organize_migrations' => 'none',
        'connection' => null,
        'em' => null,
    ],
]);
