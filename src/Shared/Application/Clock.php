<?php

declare(strict_types=1);

namespace Shared\Application;

use DateTimeInterface;

interface Clock
{
    public function now(): DateTimeInterface;
}
