<?php

declare(strict_types=1);

namespace Shared\Infrastructure\Normalizer;

use RuntimeException;
use Shared\Domain\ValueObject\Decimal;
use Shared\Domain\ValueObject\Currency;
use Shared\Domain\ValueObject\Money;
use Symfony\Component\Serializer\Normalizer\DenormalizerInterface;
use Symfony\Component\Serializer\Normalizer\NormalizerInterface;

final class MoneyNormalizer implements NormalizerInterface, DenormalizerInterface
{
    /**
     * @param Money $object
     * @param array<string, mixed> $context
     *
     * @return array<string, mixed>
     */
    public function normalize($object, ?string $format = null, array $context = []): array
    {
        return $object->toMemento();
    }

    /**
     * @param array<string, mixed> $data
     * @param array<string, mixed> $context
     */
    public function denormalize($data, string $type, ?string $format = null, array $context = []): Money
    {
        $amount = $data['amount'] ?? null;
        if (false === is_string($amount)) {
            throw new RuntimeException('Missing amount field in data');
        }

        $currency = $data['currency'] ?? null;
        if (false === is_string($currency)) {
            throw new RuntimeException('Missing currency field in data');
        }

        return new Money(new Decimal($amount), Currency::from($currency));
    }

    public function supportsNormalization($data, ?string $format = null, array $context = []): bool
    {
        return $data instanceof Money;
    }

    public function supportsDenormalization($data, string $type, ?string $format = null, array $context = []): bool
    {
        return Money::class === $type;
    }

    public function getSupportedTypes(?string $format): array
    {
        return [Money::class => true];
    }
}
