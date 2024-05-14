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
        ->host(env('DB_HOST'))
        ->port(env('DB_PORT'))
        ->dbname(env('DB_NAME'))
        ->user(env('DB_USER'))
        ->password(env('DB_PASSWORD'))
        ->serverVersion(env('DB_SERVER_VERSION'))
        ->driver(env('DB_DRIVER'));

    // ORM
    $doctrine
        ->orm()
        ->autoGenerateProxyClasses(false)
        ->entityManager('entity_manager')
        ->connection('db')
        ->autoMapping(false);

    $doctrine
        ->orm()
        ->defaultEntityManager('entity_manager');
};
