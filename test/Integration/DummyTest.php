<?php

declare(strict_types=1);

namespace Integration;

use App\Dummy;

final class DummyTest extends IntegrationTestCase
{
    public function testDummy(): void
    {
        $this->assertTrue((new Dummy())->check());
    }
}
