<?php

declare(strict_types=1);

namespace Symfony\Component\DependencyInjection\Loader\Configurator;

use Shared\UserInterface\Endpoint\Monitoring\ApplicationCheck;
use Shared\UserInterface\Endpoint\Monitoring\SentryCheck\SentryCheck;
use Symfony\Component\Routing\Loader\Configurator\Routes;

return Routes::config([
    'monitoring_application_status' => [
        'path' => '/monitoring/application',
        'controller' => ApplicationCheck::class,
        'methods' => ['GET'],
    ],
    'monitoring_sentry_status' => [
        'path' => '/monitoring/sentry',
        'controller' => SentryCheck::class,
        'methods' => ['GET'],
    ],
]);
