<?php

declare(strict_types=1);

use Shared\Application\Clock\Clock;
use Shared\Infrastructure\Clock\FixedClock;
use Symfony\Component\DependencyInjection\Loader\Configurator\ContainerConfigurator;

// @formatter:off
return static function (ContainerConfigurator $container): void {
    $services = $container->services();

    $services
        ->set(Clock::class)
        ->class(FixedClock::class)
        ->public();
};
