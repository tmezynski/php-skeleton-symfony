<?php

declare(strict_types=1);

namespace Shared\Application\Message;

use Shared\Domain\Uuid;

final readonly class TraceableStampFactory
{
    public function __construct(private string $producerName)
    {
    }

    public function createFromPrevious(TraceableStamp $traceableStamp): TraceableStamp
    {
        return new TraceableStamp(
            $this->producerName,
            Uuid::generateRandom(),
            $traceableStamp->messageId,
            $traceableStamp->correlationId,
        );
    }

    public function create(): TraceableStamp
    {
        $uuid = Uuid::generateRandom();

        return new TraceableStamp($this->producerName, $uuid, $uuid, $uuid);
    }
}
