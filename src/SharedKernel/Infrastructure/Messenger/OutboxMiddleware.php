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

final class OutboxMiddleware implements MiddlewareInterface
{
    /**
     * @throws Exception
     */
    public function handle(Envelope $envelope, StackInterface $stack): Envelope
    {
        /** @var SyncMessageInterface|ExternalAsyncMessageInterface|InternalAsyncMessageInterface $message */
        $message = $envelope->getMessage();

        if ($message instanceof SyncMessageInterface) {
            return $stack->next()->handle($envelope, $stack);
        }

        if ($message instanceof ExternalAsyncMessageInterface && $message instanceof InternalAsyncMessageInterface) {
            throw new Exception('Message can\'t be internal and external same time');
        }

        return $stack->next()->handle($envelope, $stack);
    }
}
