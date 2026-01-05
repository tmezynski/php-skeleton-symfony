<?php

declare(strict_types=1);

namespace Shared\UserInterface\ErrorController;

use ReflectionClass;
use Shared\Domain\Exception\DetailedException;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;
use Throwable;

final readonly class ErrorController
{
    public function __construct(private string $environment)
    {
    }

    public function __invoke(Throwable $exception): JsonResponse
    {
        return new JsonResponse(
            $this->getBody($exception),
            $this->getHttpCode($exception),
            [
                'Content-Type' => 'application/json',
            ],
        );
    }

    /**
     * @return array{
     *     type: string,
     *     message: string,
     *     code: int,
     *     httpCode?: int,
     * }
     */
    private function getBody(Throwable $exception): array
    {
        $reflection = new ReflectionClass($exception);

        $content = [
            'type' => $reflection->getShortName(),
            'message' => $exception->getMessage(),
            'code' => $exception->getCode(),
        ];

        if ($exception instanceof DetailedException) {
            $content = array_merge($content, [
                'httpCode' => $exception->getHttpCode(),
                'details' => $exception->getDescription(),
            ]);
        }

        if ('prod' !== $this->environment) {
            $content = array_merge($content, [
                'file' => $exception->getFile(),
                'line' => $exception->getLine(),
            ]);
        }

        return $content;
    }

    private function getHttpCode(Throwable $exception): int
    {
        if ($exception instanceof DetailedException) {
            return $exception->getHttpCode();
        }

        if ($exception instanceof NotFoundHttpException) {
            return (int)$exception->getStatusCode();
        }

        return $exception->getCode() >= 100 && $exception->getCode() < 500
            ? $exception->getCode()
            : Response::HTTP_INTERNAL_SERVER_ERROR;
    }
}
