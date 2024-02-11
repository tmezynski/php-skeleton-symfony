<?php

declare(strict_types=1);

namespace SharedKernel\Domain;

use Brick\Math\BigDecimal as MathBigDecimal;
use Brick\Math\RoundingMode;

final class BigDecimal
{
    private readonly MathBigDecimal $value;

    /**
     * @SuppressWarnings(PHPMD.StaticAccess)
     */
    public function __construct(int|float|string $value, int $scale = 0)
    {
        $value = MathBigDecimal::of($value);
        if ($scale > 0) {
            $value = $value->toScale($scale, RoundingMode::HALF_EVEN);
        }

        $this->value = $value;
    }

    public function add(self|int|float|string $decimal): self
    {
        return new self((string)$this->value->plus($this->getValue($decimal)));
    }

    public function sub(self|int|float|string $decimal): self
    {
        return new self((string)$this->value->minus($this->getValue($decimal)));
    }

    public function mul(self|int|float|string $multiplier): self
    {
        return new self((string)$this->value->multipliedBy($this->getValue($multiplier)));
    }

    public function div(self|int|float|string $divider, int $rounding = RoundingMode::HALF_EVEN): self
    {
        return new self((string)$this->value->dividedBy($this->getValue($divider), null, $rounding));
    }

    public function round(int $scale, int $rounding = RoundingMode::HALF_EVEN): self
    {
        return new self((string)$this->value->toScale($scale, $rounding));
    }

    public function __toString(): string
    {
        return (string)$this->value;
    }

    private function getValue(self|int|float|string $value): MathBigDecimal|int|float|string
    {
        return $value instanceof self ? $value->value : $value;
    }
}
