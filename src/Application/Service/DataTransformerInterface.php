<?php

namespace App\Application\Service;


/**
 * Interface DataTransformerInterface
 *
 * @package App\Application\Service
 */
interface DataTransformerInterface {
	/**
	 * @param RequestInterface $request
	 *
	 * @return object
	 */
	public function transform(RequestInterface $request);
}