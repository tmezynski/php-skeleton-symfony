<?php

declare(strict_types=1);

namespace SharedKernel\Domain;

use Ramsey\Uuid\Uuid as RamseyUuid;
use Ramsey\Uuid\UuidInterface;

final class Uuid
{
    private function __construct(private readonly UuidInterface $value)
    {
    }

    public static function generate(?string $value = null, ?string $namespace = null): self
    {
        if (null === $value) {
            return new self(RamseyUuid::uuid4());
        }

        if (null === $namespace) {
            return new self(RamseyUuid::fromString($value));
        }

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
