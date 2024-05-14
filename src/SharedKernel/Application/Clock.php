<?php

declare(strict_types=1);

namespace SharedKernel\Application;

use DateTimeInterface;

interface Clock
{
    public function now(): DateTimeInterface;
}
