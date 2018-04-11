<?php

namespace App\Domain\Model\Value;


/**
 * Class AverageValue
 *
 * @package App\Domain\Model\Value
 */
class AverageValue {
	/**
	 * @var int
	 */
	private $value;

	/**
	 * Average constructor.
	 *
	 * @param int $value
	 */
	private function __construct(int $value)
	{
		$this->value = $value;
	}

	/**
	 * @param int $value
	 *
	 * @return AverageValue
	 */
	public static function create(int $value) : self
	{
		return new self($value);
	}

	/**
	 * @return int
	 */
	public function value(): int
	{
		return $this->value;
	}

	/**
	 * @param AverageValue $average
	 *
	 * @return bool
	 */
	public function equals(AverageValue $average): bool
	{
		return $this->value === $average->value();
	}

	/**
	 * @param AverageValue $average
	 *
	 * @return bool
	 */
	public function greaterThan(AverageValue $average): bool
	{
		return $this->value > $average->value();
	}

	/**
	 * @param AverageValue $average
	 *
	 * @return bool
	 */
	public function lessThan(AverageValue $average): bool
	{
		return $this->value < $average->value();
	}

	/**
	 * {@inheritdoc}
	 */
	public function __toString() {
		return (string) $this->value;
	}
}