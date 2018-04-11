<?php

namespace App\Infrastructure\Model\Repository;


use App\Application\Serializer\SerializerInterface;
use App\Domain\Model\Entity\Tactic;
use App\Domain\Model\Repository\TacticRepositoryInterface;
use App\Infrastructure\Adapter\FileAdapter;
use Prooph\EventSourcing\Aggregate\AggregateRepository;
use Prooph\EventSourcing\Aggregate\AggregateType;
use Prooph\EventSourcing\EventStoreIntegration\AggregateTranslator;
use Prooph\EventStore\EventStore;

/**
 * Class TacticFileRepository
 *
 * @package App\Infrastructure\Model\Repository
 */
class TacticFileRepository extends AggregateRepository implements TacticRepositoryInterface
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
	 * TacticFileRepository constructor.
	 *
	 * @param EventStore          $eventStore
	 * @param SerializerInterface $serializer
	 * @param FileAdapter         $adapter
	 */
	public function __construct(EventStore $eventStore, SerializerInterface $serializer, FileAdapter $adapter)
	{
		parent::__construct($eventStore, AggregateType::fromAggregateRootClass(Tactic::class),
			new AggregateTranslator(),null, null, true);

		$this->serializer = $serializer;
		$this->adapter    = $adapter;
	}

	/**
	 * {@inheritdoc}
	 */
	public function save(Tactic $tactic): bool
	{
		$serializedObject = $this->serializer->serialize($tactic);
		$isSaved = $this->adapter->add($serializedObject, $tactic->name());

//		$this->saveAggregateRoot($tactic);

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
				$result[] = $this->serializer->deserialize($serializedData, Tactic::class);
			}
		}

		return $result;
	}

	/**
	 * {@inheritdoc}
	 */
	public function getOne(string $name): ?Tactic
	{
		$content = $this->adapter->toArray();
		if (!empty($content)) {
			foreach ($content as $serializedData) {
				/** @var Tactic $tactic */
				$tactic = $this->serializer->deserialize($serializedData, Tactic::class);
				if ($tactic->name() === $name) {
					return $tactic;
				}
			}
		}

		return null;
	}

	/**
	 * {@inheritdoc}
	 */
	public function exist(string $name): bool
	{
		return null !== $this->getOne($name);
	}

	/**
	 * {@inheritdoc}
	 */
	public function delete(string $name): bool
	{
		return $this->adapter->delete($name);
	}
}