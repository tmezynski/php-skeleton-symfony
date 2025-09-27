<?php

declare(strict_types=1);

use Psr\Log\LogLevel;
use Symfony\Config\MonologConfig;

return static function (MonologConfig $monolog): void {
    $mainHandler = $monolog->handler('filter_for_errors')
        ->type('fingers_crossed')
        ->actionLevel(LogLevel::WARNING)
        ->handler('terminal');

    $mainHandler->excludedHttpCode()->code(404);

    $monolog->handler('terminal')
        ->type('stream')
        ->processPsr3Messages(false)
        ->path('php://stderr')
        ->level(LogLevel::WARNING)
        ->channels()->elements(['!event', '!doctrine']);
};
