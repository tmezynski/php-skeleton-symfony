<?php

declare(strict_types=1);

namespace Test\Integration\Shared\Application\Command;

use PHPUnit\Framework\Attributes\Test;
use Test\Integration\IntegrationTestCase;
use Test\Utils\Dsl\Shared\CommandBusTrait;
use Test\Utils\TestDoubles\Command\Fake\FakeCommand;
use Test\Utils\TestDoubles\Event\Fake\FakeEvent;

final class FakeCommandTest extends IntegrationTestCase
{
    use CommandBusTrait;

    #[Test]
    public function canConsumeTheCommand(): void
    {
        $this->whenTheCommandIsHandled(new FakeCommand(5));

        $this->thenTheEventIsPublished(new FakeEvent(5));
    }
}
