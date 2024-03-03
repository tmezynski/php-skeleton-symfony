<?php

declare(strict_types=1);

namespace Symfony\Component\DependencyInjection\Loader\Configurator;

use Symfony\Config\DoctrineMigrationsConfig;

// @formatter:off
return static function (DoctrineMigrationsConfig $doctrineMigration): void {
    $doctrineMigration
        ->storage()
        ->tableStorage()
        ->tableName('migrations')
        ->versionColumnName('version')
        ->versionColumnLength(191)
        ->executedAtColumnName('executed_at')
        ->executionTimeColumnName('execution_time');

    $doctrineMigration->migrationsPath(
        'SharedKernel\Infrastructure\Messenger\Migration\PostgreSql',
        '%kernel.project_dir%/src/SharedKernel/Infrastructure/Messenger/Migration/PostgreSql'
    );

    $doctrineMigration
        ->allOrNothing(true)
        ->transactional(true)
        ->checkDatabasePlatform(true)
        ->organizeMigrations('none')
        ->connection(null)
        ->em(null);
};
