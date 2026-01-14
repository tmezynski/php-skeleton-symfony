<?php

declare(strict_types=1);

namespace Utils\Collection;

/**
 * @template T
 */
interface ComparableInterface
{
    /**
     * @param T $other
     */
    public function equals($other): bool;
}
