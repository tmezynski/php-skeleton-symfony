<?php

declare(strict_types=1);

namespace Shared\Domain\Message;

use Shared\Domain\ValueObject\Uuid;

final readonly class TraceableStamp
{
    public function __construct(
        public string $producerName,
        public Uuid $messageId,
        public Uuid $causationId,
        public Uuid $correlationId,
    ) {
    }
}
