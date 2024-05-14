<?php

declare(strict_types=1);

namespace SharedKernel\Domain;

use ValueError;

trait EnumTrait
{
    public static function tryFromName(string $name): ?static
    {
        foreach (self::cases() as $case) {
            if ($case->name === $name) {
                return $case;
            }
        }

        return null;
    }

    public static function fromName(string $name): static
    {
        $case = self::tryFromName($name);

        if (is_null($case)) {
            throw new ValueError(sprintf('%s is not a valid case for enum %s', $name, self::class));
        }

        return $case;
    }
}
