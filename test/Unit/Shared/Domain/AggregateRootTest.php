<?php

declare(strict_types=1);

namespace Test\Unit\Shared\Domain;

use PHPUnit\Framework\Assert;
use PHPUnit\Framework\Attributes\Test;
use PHPUnit\Framework\TestCase;
use Shared\Domain\Event\SyncEvent;
use Shared\Domain\Model\AggregateRoot;

final class AggregateRootTest extends TestCase
{
    #[Test]
    public function canCreateAggregateRootWithValidVersionAndEmptyEvents(): void
    {
        $aggregate = $this->createAggregate();

        Assert::assertEquals(0, $aggregate->version());
        Assert::assertEmpty($aggregate->popEvents());
    }

    #[Test]
    public function canPropagateEventsFromAggregate(): void
    {
        $aggregate = $this->createAggregate();
        $aggregate->addEvent($this->createEvent());

        Assert::assertCount(1, $aggregate->popEvents());
        Assert::assertCount(0, $aggregate->popEvents());
    }

    private function createAggregate(): AggregateRoot
    {
        return new class extends AggregateRoot {
        };
    }

    private function createEvent(): SyncEvent
    {
        return new class implements SyncEvent {
        };
    }
}
