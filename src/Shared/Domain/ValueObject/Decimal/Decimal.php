<?php

declare(strict_types=1);

namespace Shared\Domain\ValueObject\Decimal;

use InvalidArgumentException;

final readonly class Decimal
{
    private const int MIN_FRACTION_ACCURACY = 8;
    private const string FRACTION_CHARACTER = '.';

    /**
     * @var numeric-string
     */
    private string $value;

    /**
     * @throws InvalidArgumentException
     */
    private function __construct(string $value)
    {
        $value = !str_contains($value, ',') ? $value : str_replace(',', self::FRACTION_CHARACTER, $value);
        $this->assertValidValue($value);

        /** @var numeric-string $value */
        $this->value = '-0' !== $value ? $value : '0';
    }

    public static function from(mixed $value): self
    {
        if (is_float($value) || is_int($value)) {
            return new self((string) $value);
        }

        if (is_string($value)) {
            return new self($value);
        }

        throw new InvalidArgumentException();
    }

    public function add(Decimal $other): Decimal
    {
        return new self(bcadd($this->toString(), $other->toString(), $this->getFractionFromValues($this, $other)));
    }

    public function sub(Decimal $other): Decimal
    {
        return new self(bcsub($this->toString(), $other->toString(), $this->getFractionFromValues($this, $other)));
    }

    public function mul(Decimal $other): Decimal
    {
        return new self(bcmul($this->toString(), $other->toString(), $this->getFractionFromValues($this, $other)));
    }

    /**
     * @throws InvalidArgumentException
     */
    public function div(Decimal $other): Decimal
    {
        if ('0' === $other->toString()) {
            throw new InvalidArgumentException('Division by zero');
        }

        return new self(bcdiv($this->toString(), $other->toString(), $this->getFractionFromValues($this, $other)));
    }

    public function equals(Decimal $other): bool
    {
        return 0 === bccomp($this->toString(), $other->toString(), $this->getFractionFromValues($this, $other));
    }

    public function round(int $precision): self
    {
        if ($precision < 0) {
            throw new InvalidArgumentException(
                sprintf('Invalid value for precision: %s. Should be greater than 0.', $precision),
            );
        }

        return self::from(round((float) $this->toString(), $precision));
    }

    /**
     * @return numeric-string
     */
    public function toString(): string
    {
        return $this->value;
    }

    private function assertValidValue(string $value): void
    {
        if (false === filter_var($value, FILTER_VALIDATE_FLOAT)) {
            throw new InvalidArgumentException(sprintf('Invalid value for amount: %s', $value));
        }
    }

    private function getFractionFromValues(Decimal ...$amounts): int
    {
        $result = self::MIN_FRACTION_ACCURACY;

        foreach ($amounts as $amount) {
            $fraction = strpos($amount->toString(), self::FRACTION_CHARACTER);
            $result = max($result, false === $fraction ? 0 : strlen($amount->toString()) - 1 - $fraction);
        }

        return $result;
    }
}
