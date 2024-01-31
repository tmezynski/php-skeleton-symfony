<?php

declare(strict_types=1);

use App\Shared\Domain\ClockInterface;
use Symfony\Component\DependencyInjection\Loader\Configurator\ContainerConfigurator;
use Test\Utils\Context\DatabaseContext;
use Test\Utils\Context\DemoContext;
use Test\Utils\Context\TimeContext;
use Test\Utils\Dsl\Request\TestRequest;

use function Symfony\Component\DependencyInjection\Loader\Configurator\service;

// @formatter:off
return static function (ContainerConfigurator $container): void {
    $services = $container->services();
    $services
        ->defaults()
        ->autoconfigure();

    //Contexts
    $services
        ->set(DatabaseContext::class)
        ->args([service('doctrine.dbal.db_connection')]);

    $services
        ->set(TimeContext::class)
        ->args([service(ClockInterface::class)]);

    $services
        ->set(DemoContext::class)
        ->args([service(TestRequest::class)]);
};
