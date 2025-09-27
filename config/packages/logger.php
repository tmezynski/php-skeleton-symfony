<?php

declare(strict_types=1);

use Psr\Log\LogLevel;
use Symfony\Config\MonologConfig;

return static function (MonologConfig $monolog): void {
    $mainHandler = $monolog->handler('filter_for_errors')
        ->type('fingers_crossed')
        ->actionLevel(LogLevel::ERROR)
        ->handler('error_log');

    $mainHandler->excludedHttpCode()->code(404);

    $monolog->handler('error_log')
        ->type('stream')
        ->path('%kernel.logs_dir%/%kernel.environment%/error.log');

    $monolog->handler('messenger')
        ->type('stream')
        ->channel('messenger')
        ->level(LogLevel::DEBUG)
        ->path('%kernel.logs_dir%/messenger.log');
};
