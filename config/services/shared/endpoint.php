<?php

declare(strict_types=1);

namespace Symfony\Component\DependencyInjection\Loader\Configurator;

use Shared\Application\Logger\Logger;
use Shared\UserInterface\Action\SentryCheck;

// @formatter:off
return static function (ContainerConfigurator $container): void {
    // @formatter:on
    $services = $container->services();

    $services
        ->set(SentryCheck::class)
        ->args([service(Logger::class)])
        ->public();
};
