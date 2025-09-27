<?php

declare(strict_types=1);

use Shared\Application\Bus\EventBus;
use Symfony\Component\DependencyInjection\Loader\Configurator\ContainerConfigurator;
use Test\Utils\TestDoubles\Command\Fake\FakeCommandHandler;

use function Symfony\Component\DependencyInjection\Loader\Configurator\service;

// @formatter:off
return static function (ContainerConfigurator $container): void {
    $services = $container->services();

    $services
        ->set(FakeCommandHandler::class)
        ->args([service(EventBus::class)])
        ->tag('messenger.message_handler');
};
