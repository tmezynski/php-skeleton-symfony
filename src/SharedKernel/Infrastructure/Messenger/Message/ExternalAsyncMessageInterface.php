<?php

declare(strict_types=1);

namespace SharedKernel\Infrastructure\Messenger\Message;

use SharedKernel\Domain\Uuid;

interface ExternalAsyncMessageInterface
{
    public function id(): Uuid;

    /**
     * @return array<string, string|int|object>
     */
    public function normalize(): array;
}
