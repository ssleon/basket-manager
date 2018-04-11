<?php

namespace App\Application\Service\Player\Request;


use App\Application\Service\DataTransformerInterface;
use App\Application\Service\RequestInterface;
use App\Domain\Model\Entity\Player;
use App\Domain\Model\Value\AverageValue;
use App\Domain\Model\Value\DorsalValue;

/**
 * Class PlayerRequestTransform
 *
 * @package App\Application\Service\Player\Request
 */
class PlayerRequestTransform implements DataTransformerInterface
{
	/**
	 * @param RequestInterface|CreatePlayerRequest $request
	 *
	 * @return Player
	 * @throws \Assert\AssertionFailedException
	 */
	public function transform(RequestInterface $request)
	{
		return Player::instance(
			DorsalValue::create($request->number()),
			$request->name(),
			$request->role(),
			AverageValue::create($request->average())
		);
	}
}