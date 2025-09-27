<?php

declare(strict_types=1);

use Shared\UserInterface\Action\AppCheck;
use Symfony\Component\Routing\Loader\Configurator\RoutingConfigurator;

// @formatter:off
return static function (RoutingConfigurator $routes): void {
    // @formatter:on

    $routes
        ->add('health_check', '/app-check')
        ->controller(AppCheck::class)
        ->methods(['GET']);
};
