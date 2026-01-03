<?php

declare(strict_types=1);

namespace Test\Integration\Shared\UserInterface;

use PHPUnit\Framework\Assert;
use PHPUnit\Framework\Attributes\Test;
use Symfony\Component\HttpFoundation\Request;
use Test\Integration\IntegrationTestCase;

final class HealthCheckTest extends IntegrationTestCase
{
    #[Test]
    public function canReachHealthCheckEndpoint(): void
    {
        $response = $this->app->handle(Request::create('/app-check'));

        Assert::assertEquals(200, $response->getStatusCode());
    }
}
