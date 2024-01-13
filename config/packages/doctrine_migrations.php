<?php

declare(strict_types=1);

namespace Symfony\Component\DependencyInjection\Loader\Configurator;

use Symfony\Config\DoctrineMigrationsConfig;

// @formatter:off
return static function (DoctrineMigrationsConfig $doctrineMigration): void {
    $doctrineMigration
        ->storage()
        ->tableStorage()
        ->tableName('migration_versions_safeguarding')
        ->versionColumnName('version')
        ->versionColumnLength(191)
        ->executedAtColumnName('executed_at')
        ->executionTimeColumnName('execution_time');

    $doctrineMigration->migrationsPath('Migrations', '%kernel.project_dir%/migrations');

    $doctrineMigration
        ->allOrNothing(true)
        ->transactional(true)
        ->checkDatabasePlatform(true)
        ->organizeMigrations('none')
        ->connection(null)
        ->em(null);
};
