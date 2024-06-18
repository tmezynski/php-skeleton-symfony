<?php

declare(strict_types=1);

use Shared\Application\Clock\Clock;
use Symfony\Component\DependencyInjection\Loader\Configurator\ContainerConfigurator;
use Utils\Context\DatabaseContext;
use Utils\Context\DemoContext;
use Utils\Context\TimeContext;
use Utils\Dsl\Request\TestRequest;

use function Symfony\Component\DependencyInjection\Loader\Configurator\service;

// @formatter:off
return static function (ContainerConfigurator $container): void {
    $services = $container->services();
    $services
        ->defaults()
        ->autoconfigure();

    // Contexts
    $services
        ->set(DatabaseContext::class)
        ->args([service('doctrine.dbal.db_connection')]);

    $services
        ->set(TimeContext::class)
        ->args([service(Clock::class)]);

    $services
        ->set(DemoContext::class)
        ->args([service(TestRequest::class)]);
};
