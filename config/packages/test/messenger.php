<?php

declare(strict_types=1);

use Shared\Application\Command\AsyncCommand;
use Shared\Application\Command\SyncCommand;
use Shared\Application\Query\AsyncQuery;
use Shared\Application\Query\SyncQuery;
use Shared\Domain\Event\AsyncEvent;
use Shared\Domain\Event\SyncEvent;
use Symfony\Config\FrameworkConfig;

// @formatter:off
return static function (FrameworkConfig $framework): void {
    // @formatter:on
    $messenger = $framework->messenger();

    // Routing
    $messenger
        ->routing(SyncCommand::class)
        ->senders(['audit', 'db']);

    $messenger
        ->routing(SyncQuery::class)
        ->senders(['audit', 'db']);

    $messenger
        ->routing(SyncEvent::class)
        ->senders(['audit', 'db']);

    $messenger
        ->routing(AsyncCommand::class)
        ->senders(['audit', 'db']);

    $messenger
        ->routing(AsyncQuery::class)
        ->senders(['audit', 'db']);

    $messenger
        ->routing(AsyncEvent::class)
        ->senders(['audit', 'db']);
};
