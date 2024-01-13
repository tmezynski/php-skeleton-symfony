<?php

declare(strict_types=1);

use Acceptance\Context\DemoContext;
use App\Kernel;
use Symfony\Component\DependencyInjection\Loader\Configurator\ContainerConfigurator;

use function Symfony\Component\DependencyInjection\Loader\Configurator\service;

// @formatter:off
return static function (ContainerConfigurator $container): void {
    $services = $container->services();
    $services
        ->defaults()
        ->autoconfigure();

    $services
        ->set(DemoContext::class)
        ->args([service(Kernel::class)]);
};
