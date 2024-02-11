<?php

declare(strict_types=1);

use SharedKernel\Application\ClockInterface;
use SharedKernel\Infrastructure\Clock\FixedClock;
use Symfony\Component\DependencyInjection\Loader\Configurator\ContainerConfigurator;

// @formatter:off
return static function (ContainerConfigurator $container): void {
    $services = $container->services();

    $services
        ->set(ClockInterface::class)
        ->class(FixedClock::class)
        ->public();
};
