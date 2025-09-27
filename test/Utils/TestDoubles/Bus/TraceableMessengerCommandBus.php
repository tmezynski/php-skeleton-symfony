<?php

declare(strict_types=1);

namespace Test\Utils\TestDoubles\Bus;

use Shared\Application\Bus\CommandBus;
use Shared\Application\Command\AsyncCommand;
use Shared\Application\Command\SyncCommand;
use Symfony\Component\Messenger\Exception\HandlerFailedException;
use Symfony\Component\Messenger\MessageBusInterface;

final class TraceableMessengerCommandBus implements CommandBus
{
    /**
     * @var AsyncCommand[]|SyncCommand[]
     */
    private array $dispatchedCommands = [];

    public function __construct(private readonly MessageBusInterface $commandBus)
    {
    }

    public function dispatch(AsyncCommand|SyncCommand $command): void
    {
        try {
            $this->commandBus->dispatch($command);
            $this->dispatchedCommands[] = $command;
        } catch (HandlerFailedException $e) {
            if (null !== $e->getPrevious()) {
                throw $e->getPrevious();
            }

            throw $e;
        }
    }

    /**
     * @return AsyncCommand[]|SyncCommand[]
     */
    public function getDispatchedMessages(): array
    {
        return $this->dispatchedCommands;
    }
}
