<?php

declare(strict_types=1);

namespace Test\Integration\Shared\Application\Event;

use PHPUnit\Framework\Attributes\Test;
use Test\Integration\IntegrationTestCase;
use Test\Utils\Dsl\Shared\CommandBusTrait;

final class FakeEventTest extends IntegrationTestCase
{
    use CommandBusTrait;

    #[Test]
    public function canConsumeTheCommand(): void
    {
        $this->whenTheEventIsHandled(new FakeEvent(5));

        $this->thenNoCommandsArePublished();
        $this->thenThereAreNoPublishedEvents();
    }
}
