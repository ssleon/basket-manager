<?php

namespace App\Application\Service\Player;


use App\Application\Service\Player\Request\CreatePlayerRequest;
use App\Application\Service\Player\Request\PlayerRequestTransform;
use App\Application\Service\RequestInterface;
use App\Domain\Model\Entity\Player;
use App\Domain\Model\Value\DorsalValue;
use Assert\AssertionFailedException;
use Exception;
use LogicException;
use Prooph\Common\Event\ActionEvent;
use Prooph\EventStore\TransactionalActionEventEmitterEventStore;

/**
 * Class CreatePlayerUseCase
 *
 * @package App\Application\Service\Player
 */
class CreatePlayerUseCase extends AbstractPlayerUseCase
{
	/**
	 * @param RequestInterface|CreatePlayerRequest $request
	 *
	 * @throws LogicException|Exception
	 */
	public function execute(RequestInterface $request): void
	{
		$number = DorsalValue::create($request->number());
		if ($this->playerRepository->exist($number)) {
			throw new LogicException(sprintf('There is already a player with the dorsal number %d', $request->number()));
		}

		$this->eventStore->beginTransaction();
		try {

			$transformerObject = new PlayerRequestTransform();
			/** @var Player $player */
			$player = $transformerObject->transform($request);
			$this->playerRepository->save($player);

			$this->eventStore->attach(
				TransactionalActionEventEmitterEventStore::EVENT_COMMIT,
				function (ActionEvent $event) : void {
				}
			);

			$this->eventStore->commit();
		} catch (Exception $e) {
			$this->eventStore->rollback();
			throw $e;
		} catch ( AssertionFailedException $e ) {
		}
	}
}