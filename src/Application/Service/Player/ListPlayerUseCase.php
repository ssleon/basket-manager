<?php

namespace App\Application\Service\Player;


use App\Application\Service\Player\Request\ListPlayerRequest;
use App\Application\Service\RequestInterface;
use App\Domain\Model\Entity\Player;
use LogicException;

/**
 * Class ListPlayerUseCase
 *
 * @package App\Application\Service\Player
 */
class ListPlayerUseCase extends AbstractPlayerUseCase
{
	/**
	 * @param RequestInterface|ListPlayerRequest $request
	 *
	 * @return array
	 * @throws LogicException
	 */
	public function execute(RequestInterface $request): array
	{
		$current = $this->playerRepository->getAll();

		usort($current, function($player1, $player2) use ($request) {
			/**
			 * @var Player $player1
			 * @var Player $player2
			 */
			if ('number' === $request->orderBy()) {

				if ($player1->number()->equals($player2->number())) {
					return 0;
				}

				if ('desc' === $request->orderType()) {
					return $player1->number()->greaterThan($player2->number()) ? -1 : 1;
				}

				return $player1->number()->lessThan($player2->number()) ? -1 : 1;
			}

			if ($player1->teammateOf($player2)) {

				if ($player1->average()->equals($player2->average())) {

					return 0;

				} else {

					if ('desc' === $request->orderType()) {
						return $player1->average()->greaterThan($player2->average()) ? -1 : 1;
					}

					return !$player1->average()->greaterThan($player2->average()) ? -1 : 1;
				}

			}

			if ('desc' === $request->orderType()) {
				return $player1->role() . $player1->average() > $player2->role() . $player2->average() ? -1 : 1;
			}

			return $player1->role() . $player1->average() < $player2->role() . $player2->average() ? -1 : 1;
		});

		$result = [];
		foreach ($current as $player) {
			$result[] = $player->toArray();
		}

		return $result;
	}
}