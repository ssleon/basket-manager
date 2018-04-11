<?php

namespace App\Infrastructure\Model\Repository;


use App\Application\Serializer\SerializerInterface;
use App\Domain\Model\Entity\Player;
use App\Domain\Model\Repository\PlayerRepositoryInterface;
use App\Domain\Model\Value\DorsalValue;
use App\Infrastructure\Adapter\FileAdapter;
use Prooph\EventSourcing\Aggregate\AggregateRepository;
use Prooph\EventSourcing\Aggregate\AggregateType;
use Prooph\EventSourcing\EventStoreIntegration\AggregateTranslator;
use Prooph\EventStore\EventStore;

/**
 * Class PlayerRepository
 *
 * @package App\Infrastructure\Model\Repository
 */
class PlayerFileRepository extends AggregateRepository implements PlayerRepositoryInterface
{
	/**
	 * @var SerializerInterface
	 */
	private $serializer;
	/**
	 * @var FileAdapter
	 */
	private $adapter;

	/**
	 * PlayerFileRepository constructor.
	 *
	 * @param EventStore          $eventStore
	 * @param SerializerInterface $serializer
	 * @param FileAdapter         $adapter
	 */
	public function __construct(EventStore $eventStore, SerializerInterface $serializer, FileAdapter $adapter)
	{
		parent::__construct($eventStore, AggregateType::fromAggregateRootClass(Player::class),
			new AggregateTranslator(),null, null, false);

		$this->serializer = $serializer;
		$this->adapter    = $adapter;
	}

	/**
	 * {@inheritdoc}
	 */
	public function save(Player $player): bool
	{
		$serializedObject = $this->serializer->serialize($player);
		$isSaved = $this->adapter->add($serializedObject, $player->number()->value());

		$this->saveAggregateRoot($player);

		return $isSaved;
	}

	/**
	 * {@inheritdoc}
	 */
	public function getAll(): array
	{
		$content = $this->adapter->toArray();
		$result = [];
		if (!empty($content)) {
			foreach ($content as $serializedData) {
				$result[] = $this->serializer->deserialize($serializedData, Player::class);
			}
		}

		return $result;
	}

	/**
	 * {@inheritdoc}
	 */
	public function getOne(DorsalValue $number): ?Player
	{
		$content = $this->adapter->toArray();
		if (!empty($content)) {
			foreach ($content as $serializedData) {
				/** @var Player $player */
				$player = $this->serializer->deserialize($serializedData, Player::class);
				if ($player->number()->equals($number)) {
					return $player;
				}
			}
		}

		return null;
	}

	/**
	 * {@inheritdoc}
	 */
	public function exist(DorsalValue $number): bool
	{
		return null !== $this->getOne($number);
	}

	/**
	 * {@inheritdoc}
	 */
	public function delete(DorsalValue $number): bool
	{
		return $this->adapter->delete($number);
	}
}