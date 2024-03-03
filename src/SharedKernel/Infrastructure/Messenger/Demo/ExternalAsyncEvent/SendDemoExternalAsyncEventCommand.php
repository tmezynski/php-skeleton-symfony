<?php

declare(strict_types=1);

namespace SharedKernel\Infrastructure\Messenger\Demo\ExternalAsyncEvent;

use SharedKernel\Domain\Uuid;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\Messenger\MessageBusInterface;

final class SendDemoExternalAsyncEventCommand extends Command
{
    public function __construct(private MessageBusInterface $bus)
    {
        parent::__construct();
    }

    /**
     * @SuppressWarnings(PHPMD.UnusedFormalParameter)
     */
    protected function execute(InputInterface $input, OutputInterface $output): int //phpcs:ignore
    {
        // Message should finally go to queue.shared_event
        $message = new DemoExternalMessageInterface(Uuid::generate(), 'pig', 15);
        $this->bus->dispatch($message);

        return Command::SUCCESS;
    }
}
