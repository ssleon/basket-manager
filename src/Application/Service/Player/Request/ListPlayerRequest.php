<?php

namespace App\Application\Service\Player\Request;


use App\Application\Service\RequestInterface;

/**
 * Class ListPlayerRequest
 *
 * @package App\Application\Service\Player\Request
 */
class ListPlayerRequest implements RequestInterface
{
	/**
	 * @var string
	 */
	private $orderBy;
	/**
	 * @var string
	 */
	private $orderType;

	/**
	 * ListPlayerRequest constructor.
	 *
	 * @param string $orderBy
	 * @param string $orderType
	 */
	public function __construct(string $orderBy, string $orderType)
	{
		$this->orderBy   = $orderBy;
		$this->orderType = $orderType;
	}

	/**
	 * @return string
	 */
	public function orderBy(): string
	{
		return $this->orderBy;
	}

	/**
	 * @return string
	 */
	public function orderType(): string
	{
		return $this->orderType;
	}
}