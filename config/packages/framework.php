<?php

declare(strict_types=1);

namespace Symfony\Component\DependencyInjection\Loader\Configurator;

use Shared\UserInterface\ErrorController\ErrorController;
use Symfony\Config\FrameworkConfig;

// @formatter:off
return static function (FrameworkConfig $framework): void {
    // @formatter:on
    $framework
        ->secret(env('APP_SECRET'))
        ->httpMethodOverride(false)
        ->handleAllThrowables(true)
        ->errorController(ErrorController::class);

    $framework
        ->phpErrors()
        ->log();
};
