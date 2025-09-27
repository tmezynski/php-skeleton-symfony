<?php

declare(strict_types=1);

namespace src;

use Symfony\Bundle\FrameworkBundle\Kernel\MicroKernelTrait;
use Symfony\Component\DependencyInjection\Loader\Configurator\ContainerConfigurator;
use Symfony\Component\HttpKernel\Kernel as BaseKernel;
use Symfony\Component\Routing\Loader\Configurator\RoutingConfigurator;

final class Kernel extends BaseKernel
{
    use MicroKernelTrait;

    protected function configureContainer(ContainerConfigurator $container): void
    {
        $configDir = $this->getConfigDir();

        if ('behat' === $this->environment) {
            $container->import(sprintf('%s/{packages}/test/*.php', $configDir));
            $container->import(sprintf('%s/{services}/*/test/*.php', $configDir));
        }

        $container->import(sprintf('%s/{packages}/*.php', $configDir));
        $container->import(sprintf('%s/{packages}/%s/*.php', $configDir, $this->environment));

        $container->import(sprintf('%s/{services}/*/*.php', $configDir));
        $container->import(sprintf('%s/{services}/*/%s/*.php', $configDir, $this->environment));
    }

    protected function configureRoutes(RoutingConfigurator $routes): void
    {
        $configDir = $this->getConfigDir();
        $routes->import(sprintf('%s/{routes}/*.php', $configDir));
        $routes->import(sprintf('%s/{routes}/%s/*.php', $configDir, $this->environment));
    }
}
