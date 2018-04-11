<?php

namespace App\Application\Serializer;


use InvalidArgumentException;

/**
 * Class NativeSerializer
 *
 * @package App\Application\Serializer
 */
class NativeSerializer implements SerializerInterface
{
	/**
	 * {@inheritdoc}
	 */
	public function serialize($object) : string
	{
		return serialize($object);
	}

	/**
	 * {@inheritdoc}
	 */
	public function deserialize(string $serializedObject, string $type)
	{
		$object = unserialize($serializedObject);

		if (!$object instanceof $type) {
			throw new InvalidArgumentException(
				sprintf('Expected object type \'%s\', received type \'%s\'', $type, get_class($object))
			);
		}

		return $object;
	}
}