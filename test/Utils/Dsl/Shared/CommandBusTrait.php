<?php

declare(strict_types=1);

namespace Test\Utils\Dsl\Shared;

use PHPUnit\Framework\Assert;
use PHPUnit\Framework\ExpectationFailedException;
use Shared\Application\Bus\CommandBus;
use Shared\Application\Command\AsyncCommand;
use Shared\Application\Command\SyncCommand;
use Test\Utils\TestDoubles\Bus\TraceableMessengerCommandBus;

trait CommandBusTrait
{
    use MessengerTrait;
    use EventBusTrait;

    /**
     * @var AsyncCommand[]|SyncCommand[]
     */
    private array $givenCommands = [];

    public function whenTheCommandIsHandled(AsyncCommand|SyncCommand $command): void
    {
        $this->getCommandBus()->dispatch($command);
        $this->givenCommands[] = $command;
        $this->consumeAsyncMessage();
    }

    public function thenTheCommandIsPublished(AsyncCommand|SyncCommand $command): void
    {
        $publishedCommands = $this->getPublishedCommands();

        foreach ($publishedCommands as $publishedCommand) {
            try {
                Assert::assertEquals($publishedCommand, $command);

                return;
            } catch (ExpectationFailedException) {
            }
        }

        throw new ExpectationFailedException('Command not found');
    }

    public function thenNoCommandsArePublished(): void
    {
        $publishedCommands = $this->getPublishedCommands();

        Assert::assertEmpty(
            $publishedCommands,
            sprintf(
                'Expected no commands to be published but got %s',
                print_r($publishedCommands, true),
            ),
        );
    }

    /**
     * @return AsyncCommand[]|SyncCommand[]
     */
    private function getPublishedCommands(): array
    {
        $allSentMessages = $this->getCommandBus()->getDispatchedMessages();

        $filter = function (object $message): bool {
            return false === in_array($message, $this->givenCommands, true);
        };

        /** @var AsyncCommand[]|SyncCommand[] $dispatchedCommands */
        $dispatchedCommands = array_filter($allSentMessages, $filter);

        return array_values($dispatchedCommands);
    }

    private function getCommandBus(): TraceableMessengerCommandBus
    {
        $commandBus = $this->container->get(CommandBus::class);
        Assert::assertInstanceOf(TraceableMessengerCommandBus::class, $commandBus);

        return $commandBus;
    }
}
