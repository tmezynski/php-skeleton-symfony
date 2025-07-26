<?php

declare(strict_types=1);

namespace Symfony\Component\DependencyInjection\Loader\Configurator;

use Symfony\Config\FrameworkConfig;

// @formatter:off
return static function (FrameworkConfig $framework): void {
    $framework->secret(env('APP_SECRET'));
    $framework->test(false);
    $framework->propertyInfo()->enabled(true);
};
