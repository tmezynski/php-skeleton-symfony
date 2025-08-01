<?php

declare(strict_types=1);

namespace Shared\Infrastructure\Normalizer;

use Shared\Domain\ValueObject\Uuid;
use Symfony\Component\Serializer\Normalizer\DenormalizerInterface;
use Symfony\Component\Serializer\Normalizer\NormalizerInterface;
use Webmozart\Assert\Assert;

final class UuidNormalizer implements NormalizerInterface, DenormalizerInterface
{
    public function supportsNormalization($data, ?string $format = null, array $context = []): bool
    {
        return $data instanceof Uuid;
    }

    /**
     * @param Uuid $object
     * @param array<string, mixed> $context
     */
    public function normalize($object, ?string $format = null, array $context = []): string
    {
        return (string)$object;
    }

    public function supportsDenormalization($data, string $type, ?string $format = null, array $context = []): bool
    {
        return Uuid::class === $type;
    }

    /**
     * @param null|string $data
     * @param array<string, mixed> $context
     */
    public function denormalize($data, string $type, ?string $format = null, array $context = []): Uuid
    {
        Assert::notNull($data);

        return Uuid::fromUuidString($data);
    }

    public function getSupportedTypes(?string $format): array
    {
        return [Uuid::class => true];
    }
}
