<?php

declare(strict_types=1);

namespace Integration;

use Symfony\Bundle\FrameworkBundle\Test\KernelTestCase;

abstract class IntegrationTestCase extends KernelTestCase
{
    public function setUp(): void
    {
        parent::setUp();

        self::bootKernel(['environment' => 'test']);
    }
}
