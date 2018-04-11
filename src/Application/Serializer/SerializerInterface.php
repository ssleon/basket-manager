<?php

namespace App\Application\Serializer;


use InvalidArgumentException;

/**
 * Interface SerializerInterface
 *
 * @package App\Application\Serializer
 */
interface SerializerInterface
{
	/**
	 * @param object $object
	 *
	 * @return string
	 */
	public function serialize($object): string;

	/**
	 * @param string $serializedObject
	 * @param string $type
	 *
	 * @return object
	 * @throws InvalidArgumentException
	 */
	public function deserialize(string  $serializedObject, string $type);
}