<?php

declare(strict_types=1);

use App\Kernel;
use Symfony\Component\DependencyInjection\Loader\Configurator\ContainerConfigurator;
use Test\Utils\Context\AbstractContext;
use Test\Utils\Context\DemoContext;
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
        ->set(AbstractContext::class)
        ->abstract()
        ->call('setUp', [service(Kernel::class)]);

    $services
        ->set(DemoContext::class)
        ->parent(AbstractContext::class)
        ->args([service(TestRequest::class)]);
};
