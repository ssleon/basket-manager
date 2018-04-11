<?php

namespace App\Application\Service\Tactic\Request;


use App\Application\Service\RequestInterface;

/**
 * Class RemoveTacticRequest
 *
 * @package App\Application\Service\Tactic\Request
 */
class RemoveTacticRequest implements RequestInterface
{
	/**
	 * @var string
	 */
	private $name;

	/**
	 * RemoveTacticRequest constructor.
	 *
	 * @param string $name
	 */
	public function __construct(string $name) {
		$this->name = $name;
	}


	/**
	 * @return string
	 */
	public function name(): string
	{
		return $this->name;
	}
}