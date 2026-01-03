<?php

declare(strict_types=1);

namespace Shared\Domain\ValueObject\Enum;

trait EnumTrait
{
    public static function tryFromName(string $name): ?static
    {
        return array_find(self::cases(), fn($case) => $case->name === $name);
    }

    /**
     * @throws InvalidEnumException
     */
    public static function fromName(string $name): static
    {
        $case = self::tryFromName($name);

        if (is_null($case)) {
            throw new InvalidEnumException($name, self::class);
        }

        return $case;
    }
}
