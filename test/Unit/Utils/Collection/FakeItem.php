<?php

declare(strict_types=1);

namespace Test\Unit\Utils\Collection;

use Utils\Collection\CollectibleInterface;

/**
 * @template-implements CollectibleInterface<FakeItem>
 */
final readonly class FakeItem implements CollectibleInterface
{
    public function __construct(private int $value)
    {
    }

    /**
     * @param FakeItem $other
     */
    public function equals($other): bool
    {
        return $this->value === $other->value;
    }

    public function __toString(): string
    {
        return (string)$this->value;
    }
}
