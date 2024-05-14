<?php

declare(strict_types=1);

namespace Symfony\Component\DependencyInjection\Loader\Configurator;

use SharedKernel\Application\Clock;
use SharedKernel\Infrastructure\Clock\SystemClock;

// @formatter:off
return static function (ContainerConfigurator $container): void {
    $services = $container->services();

    $services
        ->set(Clock::class)
        ->class(SystemClock::class);
};
