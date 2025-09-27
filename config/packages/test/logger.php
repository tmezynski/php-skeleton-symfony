<?php

declare(strict_types=1);

use Psr\Log\LogLevel;
use Symfony\Config\MonologConfig;

return static function (MonologConfig $monolog): void {
    $monolog
        ->handler('main')
        ->type('stream')
        ->path('php://stdout')
        ->level(LogLevel::EMERGENCY)
        ->formatter('monolog.formatter.line');
};
