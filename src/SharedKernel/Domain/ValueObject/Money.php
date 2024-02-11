<?php

declare(strict_types=1);

namespace SharedKernel\Domain\ValueObject;

use SharedKernel\Domain\ValueObject\Money\Exception\DifferentCurrency;

final class Money
{
    private function __construct(private readonly BigDecimal $amount, private readonly Currency $currency)
    {
    }

    public static function create(float $amount, Currency $currency): self
    {
        return new self(new BigDecimal($amount, $currency->fraction()), $currency);
    }

    public function add(self $money): self
    {
        $this->assertSameCurrency($money);

        return new self(
            $this->amount->add($money->amount),
            $this->currency
        );
    }

    public function sub(self $money): self
    {
        $this->assertSameCurrency($money);

        return new self(
            $this->amount->sub($money->amount),
            $this->currency
        );
    }

    public function mul(float $multiplier): self
    {
        return new self(
            $this->amount->mul($multiplier),
            $this->currency
        );
    }

    public function div(float $divider): self
    {
        return new self(
            $this->amount->div($divider),
            $this->currency
        );
    }

    public function round(): self
    {
        return new self($this->amount->round($this->currency->fraction()), $this->currency);
    }

    private function assertSameCurrency(self $money): void
    {
        if ($this->currency === $money->currency) {
            return;
        }

        throw new DifferentCurrency($this->currency, $money->currency);
    }

    public function amount(): string
    {
        return (string)$this->amount;
    }

    public function currency(): string
    {
        return $this->currency->name;
    }
}
