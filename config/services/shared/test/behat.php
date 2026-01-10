<?php

declare(strict_types=1);

namespace Symfony\Component\DependencyInjection\Loader\Configurator;

use Shared\Application\Clock\Clock;
use Test\Utils\Context\DatabaseContext;
use Test\Utils\Context\DemoContext;
use Test\Utils\Context\TimeContext;
use Test\Utils\Dsl\Request\TestRequest;

return App::config([
    'services' => [
        DatabaseContext::class => [
            'class' => DatabaseContext::class,
            'arguments' => ['$connection' => service('doctrine.dbal.db_connection')],
        ],
        TimeContext::class => [
            'class' => TimeContext::class,
            'arguments' => ['$clock' => service(Clock::class)],
        ],
        DemoContext::class => [
            'class' => DemoContext::class,
            'arguments' => ['$testRequest' => service(TestRequest::class)],
        ],
    ],
]);
