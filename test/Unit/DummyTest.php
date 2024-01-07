<?php

declare(strict_types=1);

namespace Unit;

use App\Dummy;
use PHPUnit\Framework\TestCase;

final class DummyTest extends TestCase
{
    public function testDummy(): void
    {
        $this->assertTrue((new Dummy())->check());
    }
}
