<?php

declare(strict_types=1);

namespace SharedKernel\Unit\Domain;

use PHPUnit\Framework\TestCase;
use SharedKernel\Domain\BigDecimal;

final class BigDecimalTest extends TestCase
{
    public function testAdd(): void
    {
        $a = new BigDecimal('10.78', 4);

        $this->assertEquals('14.2100', (string)$a->add('3.43'));
        $this->assertEquals('14.2100', (string)$a->add(3.43));
        $this->assertEquals('14.2100', (string)$a->add(new BigDecimal('3.43')));
    }

    public function testSub(): void
    {
        $a = new BigDecimal('10.78', 4);

        $this->assertEquals('3.4300', (string)$a->sub('7.3500'));
        $this->assertEquals('3.4300', (string)$a->sub(7.3500));
        $this->assertEquals('3.4300', (string)$a->sub(new BigDecimal('7.3500')));
    }

    public function testMul(): void
    {
        $a = new BigDecimal('10.78', 4);

        $this->assertEquals('36.975400', (string)$a->mul('3.43'));
        $this->assertEquals('36.975400', (string)$a->mul(3.43));
        $this->assertEquals('36.975400', (string)$a->mul(new BigDecimal('3.43')));
    }

    public function testDiv(): void
    {
        $a = new BigDecimal('10.78', 4);

        $this->assertEquals('3.1429', (string)$a->div('3.43'));
        $this->assertEquals('3.1429', (string)$a->div(3.43));
        $this->assertEquals('3.1429', (string)$a->div(new BigDecimal('3.43')));
    }

    public function testRound(): void
    {
        $a = new BigDecimal('10.78', 4);
        $b = $a->round(1);

        $this->assertEquals('10.8', (string)$b);
    }
}
