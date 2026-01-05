<?php

declare(strict_types=1);

namespace Symfony\Component\DependencyInjection\Loader\Configurator;

use Shared\Application\Logger\Logger;
use Shared\UserInterface\Action\SentryCheck;
use Shared\UserInterface\ErrorController\ErrorController;

// @formatter:off
return static function (ContainerConfigurator $container): void {
    // @formatter:on
    $services = $container->services();

    $services
        ->set(ErrorController::class)
        ->args([env('APP_ENV')])
        ->public();

    $services
        ->set(SentryCheck::class)
        ->args([service(Logger::class)])
        ->public();
};
