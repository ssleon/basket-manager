<?php

namespace App\Infrastructure\Util;


use RuntimeException;

/**
 * Class Assert
 *
 * @package App\Infrastructure\Util
 */
class Assert
{
	/**
	 * @param mixed  $value
	 * @param string $label
	 *
	 * @throws  RuntimeException
	 */
	public function numeric($value, $label)
	{
		if (!is_numeric($value)) {
			throw new RuntimeException(sprintf('\'%s\' value must be numeric', $label));
		}
	}

	/**
	 * @param mixed  $value
	 * @param string $label
	 * @param int    $min
	 * @param int    $max
	 *
	 * @throws  RuntimeException
	 */
	public function withinRange($value, $label, $min, $max)
	{
		if ($value < $min || $value > $max) {
			throw new RuntimeException(sprintf('\'%s\' value must between %d and %d', $label, $min, $max));
		}
	}

	/**
	 * @param mixed  $value
	 * @param string $label
	 * @param array  $expectedValues
	 *
	 * @throws  RuntimeException
	 */
	public function valueIn($value, $label, array $expectedValues)
	{
		if (!in_array($value, $expectedValues)) {
			throw new RuntimeException(sprintf('Expected value for \'%s\': %s', $label, implode(', ', $expectedValues)));
		}
	}

	/**
	 * @param array  $data
	 * @param string $label
	 * @param int    $limit
	 *
	 * @throws  RuntimeException
	 */
	public function countEqual(array $data, $label, $limit)
	{
		if (count($data) !== $limit) {
			throw new RuntimeException(sprintf('\'%d\' %s must be specified', $limit, $label));
		}
	}

	/**
	 * @param array  $values
	 * @param string $label
	 * @param array  $expectedValues
	 */
	public function arrayValueIn(array $values, $label, array $expectedValues)
	{
		$n = 1;
		foreach ($values as $value) {
			$this->valueIn($value, $label . ' ' . $n, $expectedValues);
			$n ++;
		}
	}
}