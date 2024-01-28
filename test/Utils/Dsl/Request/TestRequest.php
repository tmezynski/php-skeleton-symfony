<?php

declare(strict_types=1);

namespace Test\Utils\Dsl\Request;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpKernel\KernelInterface;
use Webmozart\Assert\Assert;

final class TestRequest
{
    private Response $response;

    public function __construct(private readonly KernelInterface $kernel)
    {
    }

    public function get(): self
    {
        $this->response = $this->kernel->handle(Request::create('/'));

        return $this;
    }

    public function assertTheResponseIsNotFound(): self
    {
        Assert::notNull($this->response);
        Assert::eq($this->response->getStatusCode(), Response::HTTP_NOT_FOUND);

        return $this;
    }
}
