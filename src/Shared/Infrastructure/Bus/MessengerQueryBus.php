<?php

declare(strict_types=1);

namespace Shared\Infrastructure\Bus;

use Exception;
use Shared\Application\Bus\QueryBus;
use Shared\Application\Bus\QueryResult;
use Shared\Application\Query\AsyncQuery;
use Shared\Application\Query\SyncQuery;
use Symfony\Component\Messenger\MessageBusInterface;
use Symfony\Component\Messenger\Stamp\HandledStamp;

final readonly class MessengerQueryBus implements QueryBus
{
    private MessageBusInterface $queryBus;

    public function __construct(MessageBusInterface $queryBus)
    {
        $this->queryBus = $queryBus;
    }

    public function dispatch(AsyncQuery|SyncQuery $query): ?QueryResult
    {
        $envelope = $this->queryBus->dispatch($query);

        if ($query instanceof AsyncQuery) {
            return null;
        }

        /** @var HandledStamp $handledStamp */
        $handledStamp = $envelope->last(HandledStamp::class);

        $result = $handledStamp->getResult();

        if ($result instanceof QueryResult) {
            return $result;
        }

        throw new Exception(sprintf('Query handler for query %s should return QueryResult', $query::class));
    }
}
