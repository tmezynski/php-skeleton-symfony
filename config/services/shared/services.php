<?php

declare(strict_types=1);

namespace Symfony\Component\DependencyInjection\Loader\Configurator;

use Shared\Application\Clock\Clock;
use Shared\Infrastructure\Clock\SystemClock;

return App::config([
    'services' => [
        '_defaults' => [
            'autowire' => false,
            'autoconfigure' => false,
        ],
        Clock::class => ['class' => service(SystemClock::class)],
    ],
]);
