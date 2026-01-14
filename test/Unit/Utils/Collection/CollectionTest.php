<?php

declare(strict_types=1);

namespace Test\Unit\Utils\Collection;

use PHPUnit\Framework\Attributes\Test;
use PHPUnit\Framework\TestCase;
use Utils\Collection\Collection;
use Utils\Collection\ItemNotExistsInCollectionException;

final class CollectionTest extends TestCase
{
    #[Test]
    public function canCreateCollectionOfItems(): void
    {
        $items = [
            new FakeItem(1),
            new FakeItem(2),
            new FakeItem(3),
        ];

        $collection = Collection::of($items);
        $this->assertEquals(3, $collection->count());
        $this->assertTrue($collection->contains($items[0]));
        $this->assertTrue($collection->contains($items[1]));
        $this->assertTrue($collection->contains($items[2]));
    }

    #[Test]
    public function canAddNotExistingItemToCollection(): void
    {
        $item = new FakeItem(1);
        $collection = Collection::of([]);
        $collection->add($item);
        $this->assertEquals(1, $collection->count());
        $this->assertTrue($collection->contains($item));
    }

    #[Test]
    public function canDuplicateExistingItemInCollection(): void
    {
        $item = new FakeItem(1);
        $collection = Collection::of([$item]);
        $collection->add($item);
        $this->assertEquals(1, $collection->count());
        $this->assertTrue($collection->contains($item));
    }

    #[Test]
    public function canRemoveExistingItemFromCollection(): void
    {
        $item1 = new FakeItem(1);
        $item2 = new FakeItem(2);
        $collection = Collection::of([$item1, $item2]);
        $collection->remove($item1);
        $this->assertEquals(1, $collection->count());
        $this->assertFalse($collection->contains($item1));
        $this->assertTrue($collection->contains($item2));
    }

    #[Test]
    public function canNotRemoveNotExistingItemFromCollection(): void
    {
        $this->expectException(ItemNotExistsInCollectionException::class);

        $collection = Collection::of([]);
        $collection->remove(new FakeItem(1));
    }
}
