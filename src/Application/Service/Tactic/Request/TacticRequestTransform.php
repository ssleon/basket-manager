<?php

namespace App\Application\Service\Tactic\Request;


use App\Application\Service\DataTransformerInterface;
use App\Application\Service\RequestInterface;
use App\Domain\Model\Entity\Tactic;

/**
 * Class TacticRequestTransform
 *
 * @package App\Application\Service\Player\Request
 */
class TacticRequestTransform implements DataTransformerInterface
{
	/**
	 * @param RequestInterface|CreateTacticRequest $request
	 *
	 * @return object
	 * @throws \Assert\AssertionFailedException
	 */
	public function transform(RequestInterface $request)
	{
		return Tactic::instance(
			$request->name(),
			$request->positions()
		);
	}
}