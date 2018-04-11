<?php

namespace App\Domain\Model\Value;


/**
 * Class DorsalValue
 *
 * @package App\Domain\Model\Value
 */
class DorsalValue {
	/**
	 * @var int
	 */
	private $value;

	/**
	 * DorsalValue constructor.
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
	 * @return DorsalValue
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
	 * @param DorsalValue $DorsalValue
	 *
	 * @return bool
	 */
	public function equals(DorsalValue $DorsalValue): bool
	{
		return $this->value === $DorsalValue->value();
	}

	/**
	 * @param DorsalValue $DorsalValue
	 *
	 * @return bool
	 */
	public function greaterThan(DorsalValue $DorsalValue): bool
	{
		return $this->value > $DorsalValue->value();
	}

	/**
	 * @param DorsalValue $DorsalValue
	 *
	 * @return bool
	 */
	public function lessThan(DorsalValue $DorsalValue): bool
	{
		return $this->value < $DorsalValue->value();
	}

	/**
	 * {@inheritdoc}
	 */
	public function __toString() {
		return (string) $this->value;
	}
}