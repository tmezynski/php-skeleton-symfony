<?php

declare(strict_types=1);

namespace SharedKernel\Infrastructure\Messenger\Demo\SyncMessage;

use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\Messenger\MessageBusInterface;

final class SendDemoSyncMessageCommand extends Command
{
    public function __construct(private readonly MessageBusInterface $bus)
    {
        parent::__construct();
    }

    /**
     * @SuppressWarnings(PHPMD.UnusedFormalParameter)
     */
    protected function execute(InputInterface $input, OutputInterface $output): int //phpcs:ignore
    {
        $message = new DemoSyncEvent('chicken', 5);
        $this->bus->dispatch($message);

        return Command::SUCCESS;
    }
}
