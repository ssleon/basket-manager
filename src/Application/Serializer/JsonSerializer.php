<?php

namespace App\Application\Serializer;


/**
 * Class JsonSerializer
 *
 * @package App\Application\Serializer
 */
class JsonSerializer implements SerializerInterface {
	/**
	 * {@inheritdoc}
	 */
	public function serialize($object) : string
	{
		return json_encode($object);
	}

	/**
	 * {@inheritdoc}
	 */
	public function deserialize(string $serializedObject, string $type)
	{
		$data = json_decode($serializedObject, true);
		return $data;
	}
}