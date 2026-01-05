<?php

declare(strict_types=1);

use Psr\Log\LogLevel;
use Symfony\Config\MonologConfig;

use function Symfony\Component\DependencyInjection\Loader\Configurator\env;

return static function (MonologConfig $monolog): void {
    $monolog
        ->handler('sentry')
        ->type('sentry')
        ->dsn(env('SENTRY_DSN'))
        ->level(LogLevel::ERROR)
        ->priority(0)
        ->channels()->elements(['!event', '!doctrine']);

    $monolog
        ->handler('terminal')
        ->type('stream')
        ->processPsr3Messages(false)
        ->path('php://stderr')
        ->level(LogLevel::WARNING)
        ->priority(1)
        ->channels()->elements(['!event', '!doctrine']);
};
