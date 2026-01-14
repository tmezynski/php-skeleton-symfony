<?php

declare(strict_types=1);

namespace Utils\Collection;

use Stringable;

/**
 * @template T
 *
 * @template-extends ComparableInterface<T>
 */
interface CollectibleInterface extends ComparableInterface, Stringable
{
}
