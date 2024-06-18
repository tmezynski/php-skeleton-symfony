<?php

declare(strict_types=1);

namespace Shared\Domain\ValueObject;

use InvalidArgumentException;

final readonly class Amount
{
    private const MIN_FRACTION_ACCURACY = 8;
    private const FRACTION_CHARACTER = '.';

    private string $value;

    /**
     * @throws InvalidArgumentException
     */
    public function __construct(string $value)
    {
        $value = !str_contains($value, ',') ? $value : str_replace(',', self::FRACTION_CHARACTER, $value);
        $this->assertValidValue($value);
        $this->value = '-0' !== $value ? $value : '0';
    }

    public function add(Amount $other): Amount
    {
        return new self(bcadd((string)$this, (string)$other, $this->getFractionFromValues($this, $other)));
    }

    public function sub(Amount $other): Amount
    {
        return new self(bcsub((string)$this, (string)$other, $this->getFractionFromValues($this, $other)));
    }

    public function mul(Amount $other): Amount
    {
        return new self(bcmul((string)$this, (string)$other, $this->getFractionFromValues($this, $other)));
    }

    /**
     * @throws InvalidArgumentException
     */
    public function div(Amount $other): Amount
    {
        if ('0' === (string)$other) {
            throw new InvalidArgumentException('Division by zero');
        }

        return new self(bcdiv((string)$this, (string)$other, $this->getFractionFromValues($this, $other)));
    }

    public function equals(Amount $other): bool
    {
        return 0 === bccomp((string)$this, (string)$other, $this->getFractionFromValues($this, $other));
    }

    public function round(int $precision): self
    {
        if ($precision < 0) {
            throw new InvalidArgumentException(sprintf('Invalid value for precision: %s. Should be greater than 0.', $precision));
        }

        return new self((string)round((float)$this->value, $precision));
    }

    public function __toString(): string
    {
        return $this->value;
    }

    private function assertValidValue(string $value): void
    {
        if (false === filter_var($value, FILTER_VALIDATE_FLOAT)) {
            throw new InvalidArgumentException(sprintf('Invalid value for amount: %s', $value));
        }
    }

    private function getFractionFromValues(Amount ...$amounts): int
    {
        $result = self::MIN_FRACTION_ACCURACY;

        foreach ($amounts as $amount) {
            $fraction = strpos((string)$amount, self::FRACTION_CHARACTER);
            $result = max($result, false === $fraction ? 0 : strlen((string)$amount) - 1 - $fraction);
        }

        return $result;
    }
}
