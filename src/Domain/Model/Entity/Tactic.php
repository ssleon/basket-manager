<?php

namespace App\Domain\Model\Entity;
use App\Domain\Event\TacticWasCreated;
use App\Domain\Event\TacticWasDeleted;
use Prooph\EventSourcing\AggregateChanged;
use Prooph\EventStore\Util\Assertion;


/**
 * Class Tactic
 *
 * @package App\Domain\Model
 */
class Tactic {
	/**
	 * @var string
	 */
	protected $name;
	/**
	 * @var string[]
	 */
	protected $positions;

	/**
	 * Tactic constructor
	 *
	 * @param string   $name
	 * @param string[] $positions
	 */
	protected function __construct(string $name, array $positions)
	{
		$this->name      = $name;
		$this->positions = $positions;
	}

	/**
	 * @param string $name
	 * @param array $positions
	 *
	 * @return Tactic
	 * @throws \Assert\AssertionFailedException
	 */
	public static function instance(string $name, array $positions): self
	{
		Assertion::notEmpty($name);
		Assertion::notEmpty($positions);

		$tactic = new self($name, $positions);

//		$tactic->recordThat(TacticWasCreated::occur($name, $tactic->toArray()));

		return $tactic;
	}

	/**
	 * {@inheritdoc}
	 */
	protected function aggregateId(): string
	{
		return (string) $this->name;
	}

	/**
	 * @var AggregateChanged $event
	 */
	protected function apply(AggregateChanged $event): void
	{
		switch (get_class($event)) {
			case TacticWasCreated::class:
				/** @var TacticWasCreated $event */
				$this->name      = $event->name();
				$this->positions = $event->positions();

				break;
			case TacticWasDeleted::class:
				/** @var TacticWasDeleted $event */
				$this->name = $event->name();

				break;
		}
	}

	/**
	 * @return string
	 */
	public function name(): string
	{
		return $this->name;
	}

	/**
	 * @return string[]
	 */
	public function positions(): array
	{
		return $this->positions;
	}

	/**
	 * {@inheritdoc}
	 */
	public function __toString() {
		return sprintf('%s: %s', $this->name(), implode(', ', $this->positions()));
	}

	/**
	 * @return array
	 */
	public function toArray(): array
	{
		return [
			'name'      => $this->name,
			'positions' => $this->positions
		];
	}
}