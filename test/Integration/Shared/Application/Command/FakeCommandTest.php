<?php

declare(strict_types=1);

namespace Integration\Shared\Application\Command;

use PHPUnit\Framework\Attributes\Test;
use Test\Integration\IntegrationTestCase;
use Test\Utils\Dsl\Shared\CommandBusTrait;
use Test\Utils\Dsl\Shared\EventBusTrait;
use Test\Utils\TestDoubles\Command\Fake\FakeCommand;
use Test\Utils\TestDoubles\Event\Fake\FakeEvent;

final class FakeCommandTest extends IntegrationTestCase
{
    use CommandBusTrait;
    use EventBusTrait;

    #[Test]
    public function canConsumeTheCommand(): void
    {
        $this->whenTheCommandIsHandled(new FakeCommand());

        $this->thenTheEventIsPublished(new FakeEvent());
    }
}
