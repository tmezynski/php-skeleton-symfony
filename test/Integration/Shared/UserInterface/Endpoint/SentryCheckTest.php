<?php

declare(strict_types=1);

namespace Test\Integration\Shared\UserInterface\Endpoint;

use PHPUnit\Framework\Assert;
use PHPUnit\Framework\Attributes\Test;
use Symfony\Component\HttpFoundation\Request;
use Test\Integration\IntegrationTestCase;

final class SentryCheckTest extends IntegrationTestCase
{
    #[Test]
    public function canReachHealthCheckEndpoint(): void
    {
        $response = $this->app->handle(Request::create('/monitoring/sentry'));

        $body = $response->getContent();
        Assert::assertIsString($body);
        Assert::assertEquals(500, $response->getStatusCode());
        Assert::assertStringContainsString(
            '{"type":"SentryCheckException","message":"Sentry check exception","code":999,"httpCode":500,"details":"Sentry check exception"',
            $body,
        );
    }
}
