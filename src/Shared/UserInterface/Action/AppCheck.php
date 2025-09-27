<?php

declare(strict_types=1);

namespace Shared\UserInterface\Action;

use Symfony\Component\HttpFoundation\JsonResponse;

final readonly class AppCheck
{
    public function __invoke(): JsonResponse
    {
        return new JsonResponse();
    }
}
