<?php

declare(strict_types=1);

namespace Symfony\Component\DependencyInjection\Loader\Configurator;

use Symfony\Component\HttpKernel\KernelInterface;
use Test\Utils\Dsl\Request\TestRequest;

return App::config([
    'services' => [
        TestRequest::class => [
            'class' => TestRequest::class,
            'arguments' => ['$kernel' => service(KernelInterface::class)],
        ],
    ],
]);
