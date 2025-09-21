<?php

declare(strict_types=1);

namespace Shared\Infrastructure\Bus;

use Shared\Application\Bus\CommandBus;
use Shared\Application\Command\AsyncCommand;
use Shared\Application\Command\SyncCommand;
use Symfony\Component\Messenger\MessageBusInterface;

final readonly class MessengerCommandBus implements CommandBus
{
    public function __construct(private MessageBusInterface $messageBus)
    {
    }

    public function dispatch(AsyncCommand|SyncCommand $command): void
    {
        $this->messageBus->dispatch($command);
    }
}
