<?php

declare(strict_types=1);

namespace Utils\Collection;

/**
 * @template T of CollectibleInterface
 */
final class Collection
{
    /**
     * @var array<T>
     */
    private array $items = [];

    /**
     * @param array<T> $items
     *
     * @return Collection<T>
     */
    public static function of(array $items): Collection
    {
        /** @var Collection<T> $collection */
        $collection = new self();
        foreach ($items as $item) {
            $collection->add($item);
        }

        return $collection;
    }

    /**
     * @param T $item
     */
    public function add(CollectibleInterface $item): void
    {
        if (!$this->contains($item)) {
            $this->items[] = $item;
        }
    }

    /**
     * @param T $item
     *
     * @throws ItemNotExistsInCollectionException
     */
    public function remove(CollectibleInterface $item): void
    {
        if (!$this->contains($item)) {
            throw new ItemNotExistsInCollectionException($item);
        }

        $this->items = array_filter($this->items, fn($value) => !$value->equals($item));
    }

    /**
     * @param T $value
     */
    public function contains(CollectibleInterface $value): bool
    {
        return array_any($this->items, fn($item) => $item->equals($value));
    }

    public function count(): int
    {
        return count($this->items);
    }
}
