<?php

namespace App\Domain\Model\Entity;


use App\Domain\Event\PlayerWasCreated;
use App\Domain\Event\PlayerWasDeleted;
use App\Domain\Model\Value\AverageValue;
use App\Domain\Model\Value\DorsalValue;
use Prooph\EventSourcing\AggregateChanged;
use Prooph\EventSourcing\AggregateRoot;
use Prooph\EventStore\Util\Assertion;

/**
 * Class Player
 *
 * @package App\Domain\Model
 */
class Player extends AggregateRoot {
	/**
	 *
	 */
	const ALLOWED_ROLES = ['base', 'escolta', 'alero', 'ala-pivot', 'pivot'];

	/**
	 * @var DorsalValue
	 */
	protected $number;
	/**
	 * @var string
	 */
	protected $name;
	/**
	 * @var string
	 */
	protected $role;
	/**
	 * @var AverageValue
	 */
	protected $average;

	/**
	 * Player constructor
	 *
	 * @param DorsalValue  $number
	 * @param string       $name
	 * @param string       $role
	 * @param AverageValue $average
	 */
	protected function __construct(DorsalValue $number, string $name, string $role, AverageValue $average)
	{
		$this->number    = $number;
		$this->name      = $name;
		$this->role      = $role;
		$this->average   = $average;
	}

	/**
	 * @param DorsalValue $number
	 * @param string $name
	 * @param string $role
	 * @param AverageValue $average
	 *
	 * @return Player
	 * @throws \Assert\AssertionFailedException
	 */
	public static function instance(DorsalValue $number, string $name, string $role, AverageValue $average) : self
	{
		Assertion::notEmpty($number->value());
		Assertion::notEmpty($role);

		$player = new self($number, $name, $role, $average);

		$player->recordThat(PlayerWasCreated::occur($number, $player->toArray()));

		return $player;
	}

	/**
	 * {@inheritdoc}
	 */
	protected function aggregateId(): string
	{
		return (string) $this->number;
	}

	/**
	 * @var AggregateChanged $event
	 */
	protected function apply(AggregateChanged $event): void
	{
		switch (get_class($event)) {
			case PlayerWasCreated::class:
				/** @var PlayerWasCreated $event */
				$this->number  = DorsalValue::create($event->number());
				$this->name    = $event->name();
				$this->role    = $event->role();
				$this->average = AverageValue::create($event->average());

				break;
			case PlayerWasDeleted::class:
				/** @var PlayerWasDeleted $event */
				$this->number = DorsalValue::create($event->number());

				break;
		}
	}

	/**
	 * @param Player $otherPlayer
	 *
	 * @return bool
	 */
	public function teammateOf($otherPlayer): bool
	{
		if (!$otherPlayer instanceof self) {
			return false;
		}

		return $this->role === $otherPlayer->role();
	}

	/**
	 * @return DorsalValue
	 */
	public function number(): DorsalValue
	{
		return $this->number;
	}

	/**
	 * @return string
	 */
	public function name(): string
	{
		return $this->name;
	}

	/**
	 * @return string
	 */
	public function role(): string
	{
		return $this->role;
	}

	/**
	 * @return AverageValue
	 */
	public function average(): AverageValue
	{
		return $this->average;
	}

	/**
	 * @return array
	 */
	public function toArray(): array
	{
		return [
			'number'  => $this->number()->value(),
			'name'    => $this->name,
			'role'    => $this->role,
			'average' => $this->average()->value()
		];
	}
}