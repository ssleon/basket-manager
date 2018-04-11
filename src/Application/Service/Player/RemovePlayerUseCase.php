<?php

namespace App\Application\Service\Player;


use App\Application\Service\Player\Request\RemovePlayerRequest;
use App\Application\Service\RequestInterface;
use App\Domain\Model\Value\DorsalValue;
use LogicException;

/**
 * Class RemovePlayerUseCase
 *
 * @package App\Application\Service\Player
 */
class RemovePlayerUseCase extends AbstractPlayerUseCase
{
	/**
	 * @param RequestInterface|RemovePlayerRequest $request
	 *
	 * @throws LogicException
	 */
	public function execute(RequestInterface $request): void
	{
		$number = DorsalValue::create($request->number());
		if (!$this->playerRepository->exist($number)) {
			throw new LogicException(sprintf('There is no player with the dorsal number %d', $request->number()));
		}

		$this->playerRepository->delete($number);
	}
}