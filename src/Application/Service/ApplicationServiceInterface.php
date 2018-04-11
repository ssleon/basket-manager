<?php

namespace App\Application\Service;


/**
 * Interface ApplicationServiceInterface
 *
 * @package App\Application\Service
 */
interface ApplicationServiceInterface {
	/**
	 * @param RequestInterface $request
	 */
	public function execute(RequestInterface $request);
}