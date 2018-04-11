<?php

namespace App\Domain\Event;


use DateTimeImmutable;
use JsonSerializable;
use Prooph\EventSourcing\AggregateChanged;

/**
 * Class PlayerWasCreated
 *
 * @package App\Domain\Event
 */
class PlayerWasCreated extends AggregateChanged implements JsonSerializable
{
	/**
	 * PlayerWasCreated constructor.
	 *
	 * @param string $number
	 * @param array  $payload
	 */
	public function __construct(string $number, array $payload)
	{
		parent::__construct($number, [
			'number'     => $number,
			'name'       => $payload['name'],
			'role'       => $payload['role'],
			'average'    => $payload['average'],
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
	public function number(): string
	{
		return $this->payload['number'];
	}

	/**
	 * @return string
	 */
	public function name(): string
	{
		return $this->payload['name'];
	}

	/**
	 * @return string
	 */
	public function role(): string
	{
		return $this->payload['role'];
	}

	/**
	 * @return int
	 */
	public function average(): int
	{
		return $this->payload['average'];
	}

	/**
	 * {@inheritdoc}
	 */
	public function jsonSerialize() {
		return [
			'number'     => $this->number(),
			'name'       => $this->name(),
			'role'       => $this->role(),
			'average'    => $this->average(),
			'occurredOn' => $this->occurredOn()
		];
	}
}