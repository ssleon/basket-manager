<?php

namespace App\Domain\Event;


use DateTimeImmutable;
use JsonSerializable;
use Prooph\EventSourcing\AggregateChanged;

/**
 * Class TacticWasCreated
 *
 * @package App\Domain\Event
 */
class TacticWasCreated extends AggregateChanged implements JsonSerializable
{
	/**
	 * TacticWasCreated constructor.
	 *
	 * @param string $name
	 * @param string[] $positions
	 */
	public function __construct(string $name, array $positions) {
		parent::__construct($name, [
			'name'       => $name,
			'positions'  => $positions,
			'occurredOn' => new DateTimeImmutable()
		]);
	}

	/**
	 * @return DateTimeImmutable
	 */
	public function occurredOn(): DateTimeImmutable {
		return $this->payload['occurredOn'];
	}

	/**
	 * @return string
	 */
	public function name(): string {
		return $this->payload['name'];
	}

	/**
	 * @return string[]
	 */
	public function positions(): array {
		return $this->payload['positions'];
	}

	/**
	 * {@inheritdoc}
	 */
	public function jsonSerialize() {
		return [
			'name'       => $this->name(),
			'positions'  => $this->positions(),
			'occurredOn' => $this->occurredOn()
		];
	}
}