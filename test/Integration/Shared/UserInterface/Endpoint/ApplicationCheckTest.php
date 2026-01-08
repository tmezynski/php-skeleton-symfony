<?php

declare(strict_types=1);

namespace Test\Integration\Shared\UserInterface\Endpoint;

use PHPUnit\Framework\Assert;
use PHPUnit\Framework\Attributes\Test;
use Symfony\Component\HttpFoundation\Request;
use Test\Integration\IntegrationTestCase;

final class ApplicationCheckTest extends IntegrationTestCase
{
    #[Test]
    public function canReachHealthCheckEndpoint(): void
    {
        $response = $this->app->handle(Request::create('/monitoring/application'));

        Assert::assertEquals(200, $response->getStatusCode());
    }
}
