<?php

declare(strict_types=1);

namespace Test\Utils\Dsl\Shared;

use PHPUnit\Framework\Assert;
use PHPUnit\Framework\ExpectationFailedException;
use Shared\Application\Bus\EventBus;
use Shared\Domain\Event\AsyncEvent;
use Shared\Domain\Event\SyncEvent;
use Test\Utils\TestDoubles\Bus\TraceableMessengerEventBus;

trait EventBusTrait
{
    use MessengerTrait;

    /**
     * @var AsyncEvent[]|SyncEvent[]
     */
    private array $givenEvents = [];

    public function whenTheEventIsHandled(AsyncEvent|SyncEvent $event): void
    {
        $this->getTraceableBus()->dispatch($event);
        $this->givenEvents[] = $event;
        $this->consumeAsyncMessage();
    }

    public function thenTheEventIsPublished(AsyncEvent|SyncEvent $event): void
    {
        $eventBus = $this->getTraceableBus();

        foreach ($eventBus->getDispatchedMessages() as $message) {
            try {
                Assert::assertEquals($event, $message);

                return;
            } catch (ExpectationFailedException) {
                continue;
            }
        }

        throw new ExpectationFailedException('Event not found');
    }

    public function thenThereAreNoPublishedEvents(): void
    {
        $eventBus = $this->getTraceableBus();

        Assert::assertEquals(
            0,
            count($eventBus->getDispatchedMessages()) - count($this->givenEvents),
        );
    }

    private function getTraceableBus(): TraceableMessengerEventBus
    {
        $eventBus = $this->container->get(EventBus::class);
        Assert::assertInstanceOf(TraceableMessengerEventBus::class, $eventBus);

        return $eventBus;
    }
}
