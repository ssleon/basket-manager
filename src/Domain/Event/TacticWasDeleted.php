<?php

namespace App\Domain\Event;


use DateTimeImmutable;
use JsonSerializable;
use Prooph\EventSourcing\AggregateChanged;

/**
 * Class TacticWasDeleted
 *
 * @package App\Domain\Event
 */
class TacticWasDeleted extends AggregateChanged implements JsonSerializable
{
	/**
	 * TacticWasDeleted constructor.
	 *
	 * @param string            $name
	 */
	public function __construct(string $name)
	{
		parent::__construct($name, [
				'name'       => $name,
				'occurredOn' => new DateTimeImmutable()
			]
		);
	}

	/**
	 * @return string
	 */
	public function name(): string
	{
		return $this->payload['name'];
	}

	/**
	 * @return DateTimeImmutable
	 */
	public function occurredOn(): DateTimeImmutable {
		return $this->payload['occurredOn'];
	}

	/**
	 * {@inheritdoc}
	 */
	public function jsonSerialize() {
		return [
			'name'       => $this->name(),
			'occurredOn' => $this->occurredOn()
		];
	}
}