<?php

namespace App\Domain\Event;


use DateTimeImmutable;
use JsonSerializable;
use Prooph\EventSourcing\AggregateChanged;

/**
 * Class PlayerWasDeleted
 *
 * @package App\Domain\Event
 */
class PlayerWasDeleted extends AggregateChanged implements JsonSerializable
{
	/**
	 * PlayerWasCreated constructor.
	 *
	 * @param int               $number
	 */
	public function __construct(int $number)
	{
		parent::__construct($number, [
			'number'     => $number,
			'occurredOn' => new DateTimeImmutable()
		]);
	}

	/**
	 * @return int
	 */
	public function number(): int
	{
		return $this->payload['number'];
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
			'number'     => $this->number(),
			'occurredOn' => $this->occurredOn()
		];
	}
}