<?php

declare(strict_types=1);

namespace Shared\Application\Command\New;

final class NewCommandHandler
{
    /**
     * @SuppressWarnings("PHPMD.UnusedFormalParameter")
     */
    public function __invoke(NewCommand $command): void
    {
        throw new NewCommandException();
    }
}
