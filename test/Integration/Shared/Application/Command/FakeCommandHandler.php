<?php

declare(strict_types=1);

namespace Test\Integration\Shared\Application\Command;

use Shared\Application\Bus\EventBus;
use Test\Integration\Shared\Application\Event\FakeEvent;

final readonly class FakeCommandHandler
{
    public function __construct(private EventBus $eventBus)
    {
    }

    public function __invoke(FakeCommand $command): void
    {
        $this->eventBus->dispatch(new FakeEvent($command->value));
    }
}
