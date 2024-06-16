<?php

declare(strict_types=1);

namespace App;

use Symfony\Bundle\FrameworkBundle\Kernel\MicroKernelTrait;
use Symfony\Component\DependencyInjection\Loader\Configurator\ContainerConfigurator;
use Symfony\Component\HttpKernel\Kernel as BaseKernel;

final class Kernel extends BaseKernel
{
    use MicroKernelTrait;

    protected function configureContainer(ContainerConfigurator $container): void
    {
        $configDir = $this->getConfigDir();

        $container->import(sprintf('%s/{packages}/*.php', $configDir));
        $container->import(sprintf('%s/{packages}/%s/*.php', $configDir, $this->environment));

        $container->import(sprintf('%s/{services}/*.php', $configDir));
        $container->import(sprintf('%s/{services}/%s/*.php', $configDir, $this->environment));
    }
}
