<?php

declare(strict_types=1);

namespace SharedKernel\Application\Demo\SyncMessage;

use SharedKernel\Application\Message\AbstractTraceableMessage;
use SharedKernel\Application\Message\SyncMessage;

final class DemoSyncEvent extends AbstractTraceableMessage implements SyncMessage
{
    public function __construct(public readonly string $name, public readonly int $value)
    {
    }
}
