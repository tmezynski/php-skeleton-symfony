<?php

declare(strict_types=1);

namespace Test\Utils\Dsl\Shared;

use Symfony\Bundle\FrameworkBundle\Console\Application;
use Symfony\Component\Console\Tester\CommandTester;
use Symfony\Component\Messenger\Event\WorkerMessageFailedEvent;
use Throwable;

trait MessengerTrait
{
    private function consumeAsyncMessage(string $transport = 'db'): void
    {
        $application = new Application($this->app);
        $command = $application->find('messenger:consume');
        $commandTester = new CommandTester($command);

        try {
            $commandTester->execute([
                'receivers' => [$transport],
                '--limit' => 1,
                '--time-limit' => 1,
            ]);
        } catch (Throwable $e) {
            throw $this->extractRealHandlerException($e) ?? $e;
        }
    }

    private function extractRealHandlerException(Throwable $e): ?Throwable
    {
        foreach ($e->getTrace() as $trace) {
            $workerMessageEvent = $trace['args'][0] ?? null;
            if ($workerMessageEvent instanceof WorkerMessageFailedEvent) {
                return $workerMessageEvent->getThrowable()->getPrevious() ?? $workerMessageEvent->getThrowable();
            }
        }

        return null;
    }
}
