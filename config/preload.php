<?php

declare(strict_types=1);

$preloadFile = dirname(__DIR__) . '/var/cache/prod/App_KernelProdContainer.preload.php';

if (file_exists($preloadFile)) {
    include $preloadFile;
}
