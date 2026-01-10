<?php

declare(strict_types=1);

namespace Symfony\Component\DependencyInjection\Loader\Configurator;

use Utils\ErrorController\ErrorController;

return App::config([
    'parameters' => [
        'suppressEnvs' => [env('SENTRY_DSN')->string()],
    ],
    'framework' => [
        'secret' => env('APP_SECRET')->string(),
        'http_method_override' => false,
        'handle_all_throwables' => true,
        'error_controller' => ErrorController::class,

        'php_errors' => [
            'log' => true,
        ],
        'router' => [
            'utf8' => true,
        ],
    ],
]);
