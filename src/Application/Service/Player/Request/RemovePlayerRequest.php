<?php

namespace App\Application\Service\Player\Request;


use App\Application\Service\RequestInterface;

/**
 * Class RemovePlayerRequest
 *
 * @package App\Application\Service\Player\Request
 */
class RemovePlayerRequest implements RequestInterface
{
	/**
	 * @var int
	 */
	private $number;

	/**
	 * RemovePlayerRequest constructor.
	 *
	 * @param int $number
	 */
	public function __construct(int $number) {
		$this->number = $number;
	}


	/**
	 * @return int
	 */
	public function number(): int
	{
		return $this->number;
	}
}