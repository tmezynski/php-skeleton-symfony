<?php

declare(strict_types=1);

namespace Symfony\Component\DependencyInjection\Loader\Configurator;

use Monolog\Formatter\LineFormatter;
use Psr\Log\LoggerInterface;
use Shared\Application\Logger\Logger;
use Shared\Infrastructure\Logger\MonologLogger;

return function (ContainerConfigurator $container): void {
    $services = $container->services();

    $services->set('monolog.formatter.line', LineFormatter::class)
        ->args([
            '[%%datetime%%][' . env('APP_NAME') . '][%%level_name%%] %%message%% | Context: %%context%%' . PHP_EOL,
            'Y-m-d H:i:s',
            true,
            true,
        ]);

    $services->set(Logger::class, MonologLogger::class)
        ->args([service(LoggerInterface::class)]);
};
