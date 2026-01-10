<?php

declare(strict_types=1);

namespace Symfony\Component\DependencyInjection\Loader\Configurator;

use Shared\Application\Clock\Clock;
use Test\Utils\TestDoubles\Clock\FixedClock;

return App::config([
    'services' => [
        Clock::class => [
            'class' => FixedClock::class,
            'public' => true,
        ],
    ],
]);
