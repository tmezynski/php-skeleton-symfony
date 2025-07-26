<?php

declare(strict_types=1);

namespace Symfony\Component\DependencyInjection\Loader\Configurator;

use Shared\Domain\Message\TraceableStampFactory;
use Shared\Infrastructure\Messenger\MessageSerializer;
use Shared\Infrastructure\Messenger\UnlimitedRetryStrategy;
use Shared\Infrastructure\Normalizer\MoneyNormalizer;
use Shared\Infrastructure\Normalizer\UuidNormalizer;
use Symfony\Component\Serializer\Encoder\JsonEncoder;
use Symfony\Component\Serializer\Normalizer\ArrayDenormalizer;
use Symfony\Component\Serializer\Normalizer\DateTimeNormalizer;
use Symfony\Component\Serializer\Normalizer\ObjectNormalizer;
use Symfony\Component\Serializer\Normalizer\PropertyNormalizer;
use Symfony\Component\Serializer\Serializer;

return static function (ContainerConfigurator $containerConfigurator): void {
    $services = $containerConfigurator->services();

    $services->defaults()
        ->autowire(true)
        ->autoconfigure();

    $services->set(DateTimeNormalizer::class);
    $services->set(UuidNormalizer::class);
    $services->set(MoneyNormalizer::class);
    $services->set(ArrayDenormalizer::class);
    $services->set(PropertyNormalizer::class);
    $services->set(ObjectNormalizer::class);
    $services->set(JsonEncoder::class);

    $services
        ->set(Serializer::class)
        ->args([
            [
                service(DateTimeNormalizer::class),
                service(UuidNormalizer::class),
                service(MoneyNormalizer::class),
                service(ArrayDenormalizer::class),
                service(PropertyNormalizer::class),
                service(ObjectNormalizer::class),
            ],
            [
                service(JsonEncoder::class),
            ],
        ]);

    $services
        ->set(MessageSerializer::class)
        ->args([service('serializer')]);

    $services
        ->set(UnlimitedRetryStrategy::class);

    $services
        ->set(TraceableStampFactory::class)
        ->args([env('APP_NAME')]);
};
