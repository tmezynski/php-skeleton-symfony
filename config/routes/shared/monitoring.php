<?php

declare(strict_types=1);

use Shared\UserInterface\Action\Monitoring\ApplicationCheck;
use Shared\UserInterface\Action\Monitoring\SentryCheck;
use Symfony\Component\Routing\Loader\Configurator\RoutingConfigurator;

// @formatter:off
return static function (RoutingConfigurator $routes): void {
    // @formatter:on

    $routes
        ->add('monitoring_application_status', '/monitoring/application')
        ->controller(ApplicationCheck::class)
        ->methods(['GET']);

    $routes
        ->add('monitoring_sentry_status', '/monitoring/sentry')
        ->controller(SentryCheck::class)
        ->methods(['GET']);
};
