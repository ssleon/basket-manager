<?php

namespace App\Application\Service\Tactic\Request;


use App\Application\Service\RequestInterface;

/**
 * Class CalculateAlignmentRequest
 *
 * @package App\Application\Service\Tactic\Request
 */
class CalculateAlignmentRequest implements RequestInterface {
	/**
	 * @var string
	 */
	private $tacticName;
	/**
	 * @var array
	 */
	private $defaultTactics;

	/**
	 * CalculateAlignmentRequest constructor.
	 *
	 * @param string $tacticName
	 * @param array  $defaultTactics
	 */
	public function __construct(string $tacticName, array $defaultTactics)
	{
		$this->tacticName     = $tacticName;
		$this->defaultTactics = $defaultTactics;
	}

	/**
	 * @return string
	 */
	public function tacticName(): string
	{
		return $this->tacticName;
	}

	/**
	 * @return array
	 */
	public function defaultTactics(): array
	{
		return $this->defaultTactics;
	}
}