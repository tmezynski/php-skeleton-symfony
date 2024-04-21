<?php

declare(strict_types=1);

namespace Symfony\Component\DependencyInjection\Loader\Configurator;

use SharedKernel\Application\Message\TraceableStampFactory;
use SharedKernel\Infrastructure\Messenger\MessageSerializer;
use SharedKernel\Infrastructure\Messenger\Normalizer\ValueObject\MoneyNormalizer;
use SharedKernel\Infrastructure\Messenger\Normalizer\ValueObject\UuidNormalizer;
use SharedKernel\Infrastructure\Messenger\UnlimitedRetryStrategy;
use Symfony\Component\Serializer\Encoder\JsonEncoder;
use Symfony\Component\Serializer\Normalizer\ArrayDenormalizer;
use Symfony\Component\Serializer\Normalizer\DateTimeNormalizer;
use Symfony\Component\Serializer\Normalizer\ObjectNormalizer;
use Symfony\Component\Serializer\Normalizer\PropertyNormalizer;
use Symfony\Component\Serializer\Serializer;

return static function (ContainerConfigurator $containerConfigurator): void
{
    $services = $containerConfigurator->services();

    $services->defaults()
        ->autowire(false)
        ->autoconfigure();

    $services->set(UuidNormalizer::class);
    $services->set(MoneyNormalizer::class);
    $services->set(DateTimeNormalizer::class);
    $services->set(ArrayDenormalizer::class);
    $services->set(PropertyNormalizer::class);
    $services->set(ObjectNormalizer::class);
    $services->set(JsonEncoder::class);

    $services
        ->set(Serializer::class)
        ->args([
            [
                service(UuidNormalizer::class),
                service(MoneyNormalizer::class),
                service(DateTimeNormalizer::class),
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
        ->args([service(Serializer::class)]);

    $services
        ->set(UnlimitedRetryStrategy::class);

    $services
        ->set(TraceableStampFactory::class)
        ->args([env('APP_NAME')]);
};
