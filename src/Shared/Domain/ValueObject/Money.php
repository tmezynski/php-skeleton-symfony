<?php

declare(strict_types=1);

namespace Shared\Domain\ValueObject;

use InvalidArgumentException;
use Shared\Domain\ValueObject\Decimal\Decimal;

final readonly class Money
{
    public function __construct(private Decimal $amount, private Currency $currency)
    {
    }

    public function add(Money $other): Money
    {
        $this->assertSameCurrency($other);

        return new self($this->amount->add($other->amount), $this->currency);
    }

    public function sub(Money $other): Money
    {
        $this->assertSameCurrency($other);

        return new self($this->amount->sub($other->amount), $this->currency);
    }

    public function mul(Decimal $multiplier): Money
    {
        return new self($this->amount->mul($multiplier), $this->currency);
    }

    /**
     * @throws InvalidArgumentException
     */
    public function div(Decimal $divisor): Money
    {
        return new self($this->amount->div($divisor), $this->currency);
    }

    public function round(?int $precision = null): Money
    {
        if (is_null($precision)) {
            $precision = $this->currency->fraction();
        }

        return new self($this->amount->round($precision), $this->currency);
    }

    public function equals(Money $other): bool
    {
        return $this->amount->equals($other->amount)
            && $this->currency === $other->currency;
    }

    public function equalsRounded(Money $other): bool
    {
        return $this->round()->amount->equals($other->round()->amount)
            && $this->currency === $other->currency;
    }

    /**
     * @throws InvalidArgumentException
     */
    private function assertSameCurrency(Money $other): void
    {
        if ($this->currency !== $other->currency) {
            throw new InvalidArgumentException('Currencies must match');
        }
    }

    public function __toString(): string
    {
        return sprintf(
            '%s %s',
            $this->amount->round($this->currency->fraction())->toString(),
            $this->currency->name,
        );
    }

    /**
     * @return array{'amount': string, 'currency': string}
     */
    public function toMemento(): array
    {
        return [
            'amount' => $this->amount->toString(),
            'currency' => $this->currency->name,
        ];
    }

    /**
     * @param array{'amount': string, 'currency': string} $data
     */
    public static function fromMemento(array $data): self
    {
        return new self(Decimal::from($data['amount']), Currency::fromName($data['currency']));
    }
}
