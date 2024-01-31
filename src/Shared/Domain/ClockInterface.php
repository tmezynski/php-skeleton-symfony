<?php

declare(strict_types=1);

namespace App\Shared\Domain;

use DateTimeInterface;

interface ClockInterface
{
    public function now(): DateTimeInterface;
}
