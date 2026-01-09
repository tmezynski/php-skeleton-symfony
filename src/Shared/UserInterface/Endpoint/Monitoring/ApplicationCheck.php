<?php

declare(strict_types=1);

namespace Shared\UserInterface\Endpoint\Monitoring;

use Symfony\Component\HttpFoundation\JsonResponse;

final readonly class ApplicationCheck
{
    public function __invoke(): JsonResponse
    {
        return new JsonResponse();
    }
}
