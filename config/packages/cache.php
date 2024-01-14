<?php

declare(strict_types=1);

namespace Symfony\Component\DependencyInjection\Loader\Configurator;

use Symfony\Config\FrameworkConfig;

// @formatter:off
return static function (FrameworkConfig $framework): void {
    $cache = $framework->cache();

    $cache->defaultRedisProvider(env('REDIS_URL'));

    $cache
        ->system('cache.adapter.system')
        ->app('cache.adapter.filesystem');

    $cache
        ->pool('cache.app.redis')
        ->adapters('cache.adapter.redis');

    $cache
        ->pool('cache.doctrine.orm.default.metadata')
        ->adapters('cache.adapter.redis');

    $cache
        ->pool('cache.doctrine.orm.default.result')
        ->adapters('cache.adapter.redis');

    $cache
        ->pool('cache.doctrine.orm.default.query')
        ->adapters('cache.adapter.redis');
};
