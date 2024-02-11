<?php

declare(strict_types=1);

namespace SharedKernel\Application;

use DateTimeInterface;

interface ClockInterface
{
    public function now(): DateTimeInterface;
}
