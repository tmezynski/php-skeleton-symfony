<?php

declare(strict_types=1);

use Shared\Application\Clock\Clock;
use Symfony\Component\DependencyInjection\Loader\Configurator\ContainerConfigurator;
use Test\Utils\TestDoubles\Clock\FixedClock;

// @formatter:off
return static function (ContainerConfigurator $container): void {
    $services = $container->services();

    $services
        ->set(Clock::class)
        ->class(FixedClock::class)
        ->public();
};
