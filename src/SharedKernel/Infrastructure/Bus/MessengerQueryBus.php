<?php

declare(strict_types=1);

namespace SharedKernel\Infrastructure\Bus;

use Exception;
use SharedKernel\Application\Bus\QueryBus;
use SharedKernel\Application\Bus\QueryResult;
use SharedKernel\Application\Query\AsyncQuery;
use SharedKernel\Application\Query\SyncQuery;
use Symfony\Component\Messenger\MessageBusInterface;
use Symfony\Component\Messenger\Stamp\HandledStamp;

final readonly class MessengerQueryBus implements QueryBus
{
    private MessageBusInterface $queryBus;

    public function __construct(MessageBusInterface $queryBus)
    {
        $this->queryBus = $queryBus;
    }

    /**
     * @throws Exception
     */
    public function execute(AsyncQuery|SyncQuery $query): QueryResult
    {
        $envelope = $this->queryBus->dispatch($query);

        /** @var HandledStamp $handledStamp */
        $handledStamp = $envelope->last(HandledStamp::class);

        $result = $handledStamp->getResult();

        if ($result instanceof QueryResult) {
            return $result;
        }

        throw new Exception(sprintf('Query handler for query %s should return QueryResult', $query::class));
    }
}
