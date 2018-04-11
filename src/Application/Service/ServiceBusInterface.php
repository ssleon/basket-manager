<?php

namespace App\Application\Service;


/**
 * Interface ServiceBusInterface
 *
 * @package App\Application\Service
 */
interface ServiceBusInterface {
	/**
	 * @param string                      $requestName
	 * @param ApplicationServiceInterface $handler
	 *
	 * @return ServiceBusInterface
	 */
	public function addHandler(string $requestName, ApplicationServiceInterface $handler): ServiceBusInterface;

	/**
	 * @param RequestInterface $request
	 */
	public function handle(RequestInterface $request);
}