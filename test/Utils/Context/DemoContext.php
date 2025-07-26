<?php

declare(strict_types=1);

namespace Test\Utils\Context;

use Behat\Behat\Context\Context;
use Test\Utils\Dsl\Request\TestRequest;

final class DemoContext implements Context
{
    public function __construct(private readonly TestRequest $testRequest)
    {
    }

    /**
     * @When a demo scenario sends a request to default path
     */
    public function demoScenarioSendsRequestTo(): void
    {
        $this->testRequest->get();
    }

    /**
     * @Then the response is not found
     */
    public function thenTheResponseIsNotFound(): void
    {
        $this->testRequest->assertTheResponseIsNotFound();
    }
}
