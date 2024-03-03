<?php

declare(strict_types=1);

namespace SharedKernel\Infrastructure\Messenger\Demo\ExternalAsyncEvent;

use ReflectionClass;
use Symfony\Component\Messenger\Attribute\AsMessageHandler;

#[AsMessageHandler(fromTransport: 'outbox')]
final class ExternalMessageSender
{
    public function __construct(private readonly string $producerName)
    {
    }

    public function __invoke(ExternalMessageInterface $message): void
    {
        echo sprintf(
            "Sent message to external system: %s, event: %s, producer: %s, body: %s\n",
            $message->id(),
            (new ReflectionClass(get_class($message)))->getShortName(),
            $this->producerName,
            serialize($message->normalize())
        );
    }
}
