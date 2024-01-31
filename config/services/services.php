<?php

declare(strict_types=1);

namespace Symfony\Component\DependencyInjection\Loader\Configurator;

use App\Shared\Domain\ClockInterface;
use App\Shared\Infrastructure\Clock\SystemClock;

//@formatter:off
return static function (ContainerConfigurator $container): void {
    $services = $container->services();

    $services
        ->set(ClockInterface::class)
        ->class(SystemClock::class);
};
