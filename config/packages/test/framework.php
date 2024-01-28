<?php

declare(strict_types=1);

use Symfony\Config\FrameworkConfig;

use function Symfony\Component\DependencyInjection\Loader\Configurator\env;

// @formatter:off
return static function (FrameworkConfig $framework): void {
    $framework->secret(env('APP_SECRET'));
    $framework->test(true);
};
