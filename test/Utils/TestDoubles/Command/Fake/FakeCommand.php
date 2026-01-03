<?php

declare(strict_types=1);

namespace Test\Utils\TestDoubles\Command\Fake;

use Shared\Application\Command\SyncCommand;

final readonly class FakeCommand implements SyncCommand
{
    public function __construct(public int $value)
    {
    }
}
