<?php

declare(strict_types=1);

use Symfony\Component\DependencyInjection\Loader\Configurator\ContainerConfigurator;
use Symfony\Component\HttpKernel\KernelInterface;
use Test\Utils\Dsl\ContainerProxy;

use function Symfony\Component\DependencyInjection\Loader\Configurator\service;

// @formatter:off
return static function (ContainerConfigurator $container): void {
    $services = $container->services();

    //Contexts
    $services
        ->set(ContainerProxy::class)
        ->public()
        ->args([service(KernelInterface::class)]);
};
