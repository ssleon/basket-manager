<?php

namespace App\Application\Bus;


use App\Application\Service\ApplicationServiceInterface;
use App\Application\Service\ServiceBusInterface;
use App\Application\Service\RequestInterface;
use InvalidArgumentException;

/**
 * Class ServiceBus
 *
 * @package App\Application\Bus
 */
class ServiceBus implements ServiceBusInterface
{
	/**
	 * @var ApplicationServiceInterface[]
	 */
	private $handlers;

	/**
	 * {@inheritdoc}
	 */
	public function addHandler(string $requestName, ApplicationServiceInterface $handler): ServiceBusInterface
	{
		$this->handlers[$requestName] = $handler;

		return $this;
	}

	/**
	 * {@inheritdoc}
	 */
	public function handle(RequestInterface $request)
	{
		if (!array_key_exists($requestName = get_class($request), $this->handlers)) {
			throw new InvalidArgumentException(sprintf('Handler for request \'%s\' is not defined', $requestName));
		}

		return $this->handlers[$requestName]->execute($request);
	}
}