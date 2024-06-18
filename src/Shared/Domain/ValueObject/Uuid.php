<?php

declare(strict_types=1);

namespace Shared\Domain\ValueObject;

use Ramsey\Uuid\Uuid as RamseyUuid;
use Ramsey\Uuid\UuidInterface;

final readonly class Uuid
{
    private function __construct(private UuidInterface $value)
    {
    }

    public static function generateRandom(): self
    {
        return new self(RamseyUuid::uuid4());
    }

    public static function fromUuidString(string $value): self
    {
        return new self(RamseyUuid::fromString($value));
    }

    public static function fromUuidStringAndNamespace(string $value, string $namespace): self
    {
        return new self(RamseyUuid::uuid5($namespace, $value));
    }

    public function equals(self $uuid): bool
    {
        return (string)$this === (string)$uuid->value;
    }

    public function __toString(): string
    {
        return (string)$this->value;
    }
}
