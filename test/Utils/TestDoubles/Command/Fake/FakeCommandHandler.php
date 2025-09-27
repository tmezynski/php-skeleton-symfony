<?php

declare(strict_types=1);

namespace Test\Utils\TestDoubles\Command\Fake;

use Shared\Application\Bus\EventBus;
use Test\Utils\TestDoubles\Event\Fake\FakeEvent;

final readonly class FakeCommandHandler
{
    public function __construct(private EventBus $eventBus)
    {
    }

    public function __invoke(FakeCommand $command): void
    {
        $this->eventBus->dispatch(new FakeEvent());
    }
}
