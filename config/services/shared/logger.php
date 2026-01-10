<?php

declare(strict_types=1);

namespace Symfony\Component\DependencyInjection\Loader\Configurator;

use Monolog\Formatter\LineFormatter;
use Psr\Log\LoggerInterface;
use Shared\Application\Logger\Logger;
use Shared\Infrastructure\Logger\MonologLogger;

return App::config([
    'services' => [
        'monolog.formatter.line' => [
            'class' => LineFormatter::class,
            'arguments' => [
                '$format' => '[%%datetime%%][' . env('APP_NAME')->string()
                    . '][%%level_name%%] %%message%% | Context: %%context%%' . PHP_EOL,
                '$dateFormat' => 'Y-m-d H:i:s',
                '$allowInlineLineBreaks' => true,
                '$ignoreEmptyContextAndExtra' => true,
            ],
        ],
        Logger::class => [
            'class' => MonologLogger::class,
            'arguments' => ['$logger' => service(LoggerInterface::class)],
        ],
    ],
]);
