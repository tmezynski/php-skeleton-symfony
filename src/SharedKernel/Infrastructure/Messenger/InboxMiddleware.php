<?php

declare(strict_types=1);

namespace SharedKernel\Infrastructure\Messenger;

use Exception;
use SharedKernel\Infrastructure\Messenger\Message\ExternalAsyncMessageInterface;
use SharedKernel\Infrastructure\Messenger\Message\InternalAsyncMessageInterface;
use SharedKernel\Infrastructure\Messenger\Message\SyncMessageInterface;
use Symfony\Component\Messenger\Envelope;
use Symfony\Component\Messenger\Middleware\MiddlewareInterface;
use Symfony\Component\Messenger\Middleware\StackInterface;

final class InboxMiddleware implements MiddlewareInterface
{
    /**
     * @throws Exception
     */
    public function handle(Envelope $envelope, StackInterface $stack): Envelope
    {
        /** @var SyncMessageInterface|ExternalAsyncMessageInterface|InternalAsyncMessageInterface $message */
        $message = $envelope->getMessage();

        if (false === $message instanceof InternalAsyncMessageInterface) {
            throw new Exception('Message must be instance of InternalAsyncMessageInterface');
        }

        return $stack->next()->handle($envelope, $stack);
    }
}
