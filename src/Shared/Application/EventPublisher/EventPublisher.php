<?php

declare(strict_types=1);

namespace Shared\Application\EventPublisher;

interface EventPublisher
{
    public function publish(): void;
}
