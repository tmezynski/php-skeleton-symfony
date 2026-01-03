<?php

declare(strict_types=1);

namespace Test\Integration\Shared\Application\Event;

use PHPUnit\Framework\Attributes\Test;
use Test\Integration\IntegrationTestCase;
use Test\Utils\Dsl\Shared\CommandBusTrait;
use Test\Utils\Dsl\Shared\EventBusTrait;
use Test\Utils\TestDoubles\Event\Fake\FakeEvent;

final class FakeEventTest extends IntegrationTestCase
{
    use EventBusTrait;
    use CommandBusTrait;

    #[Test]
    public function canConsumeTheCommand(): void
    {
        $this->whenTheEventIsHandled(new FakeEvent());

        $this->thenNoCommandsArePublished();
        $this->thenThereAreNoPublishedEvents();
    }
}
