<?php

declare(strict_types=1);

namespace Symfony\Component\DependencyInjection\Loader\Configurator;

use Symfony\Config\DoctrineConfig;

// @formatter:off
return static function (DoctrineConfig $doctrine): void {
    // DBAL
    $doctrine
        ->dbal()
        ->connection('db')
        ->url(env('DATABASE_URL'))
        ->driver(env('DB_DRIVER'))
        ->mappingType('enum', 'string');

    $doctrine
        ->orm()
        ->entityManager('entity_manager')
        ->connection('db')
        ->autoMapping(false);
};
