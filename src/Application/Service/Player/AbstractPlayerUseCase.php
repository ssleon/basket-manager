<?php

namespace App\Application\Service\Player;


use App\Application\Service\ApplicationServiceInterface;
use App\Domain\Model\Repository\PlayerRepositoryInterface;
use Prooph\EventStore\EventStore;
use Prooph\EventStore\TransactionalActionEventEmitterEventStore;

/**
 * Class AbstractPlayerUseCase
 *
 * @package App\Application\Service\Player
 */
abstract class AbstractPlayerUseCase implements ApplicationServiceInterface
{
	/**
	 * @var PlayerRepositoryInterface
	 */
	protected $playerRepository;
	/**
	 * @var EventStore|TransactionalActionEventEmitterEventStore
	 */
	protected $eventStore;

	/**
	 * CreatePlayerUseCase constructor
	 *
	 * @param PlayerRepositoryInterface $playerRepository
	 * @param EventStore|null           $eventStore
	 */
	public function __construct(PlayerRepositoryInterface $playerRepository, EventStore $eventStore = null)
	{
		$this->playerRepository = $playerRepository;
		$this->eventStore       = $eventStore;
	}
}