<?php

namespace App\Application\Service\Player\Request;


use App\Application\Service\RequestInterface;

/**
 * Class CreatePlayerRequest
 *
 * @package App\Application\Service\Player\Request
 */
class CreatePlayerRequest implements RequestInterface
{
	/**
	 * @var int
	 */
	private $number;
	/**
	 * @var string
	 */
	private $name;
	/**
	 * @var string
	 */
	private $role;
	/**
	 * @var int
	 */
	private $average;

	/**
	 * CreatePlayerRequest constructor
	 *
	 * @param int    $number
	 * @param string $name
	 * @param string $role
	 * @param int    $average
	 */
	public function __construct(int $number, string $name, string $role, int $average)
	{
		$this->number  = $number;
		$this->name    = $name;
		$this->role    = $role;
		$this->average = $average;
	}

	/**
	 * @return int
	 */
	public function number(): int
	{
		return $this->number;
	}

	/**
	 * @return string
	 */
	public function name(): string
	{
		return $this->name;
	}

	/**
	 * @return string
	 */
	public function role(): string
	{
		return $this->role;
	}

	/**
	 * @return int
	 */
	public function average(): int
	{
		return $this->average;
	}
}