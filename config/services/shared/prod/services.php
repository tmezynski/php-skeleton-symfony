<?php

declare(strict_types=1);

namespace Symfony\Component\DependencyInjection\Loader\Configurator;

// @formatter:off
return static function (ContainerConfigurator $container): void {
    // @formatter:on
    $container->parameters()->set('debug.container.dump', false);
};
