<?php

namespace App\Infrastructure\Adapter;


use InvalidArgumentException;

/**
 * Class FileAdapter
 *
 * @package App\Infrastructure\Adapter
 */
class FileAdapter
{
	/**
	 * @var string
	 */
	private $filename;

	/**
	 * FileAdapter constructor.
	 *
	 * @param string $filename
	 */
	public function __construct(string $filename)
	{
		if (empty($filename) || !is_dir(dirname($filename))) {
			throw new InvalidArgumentException(sprintf('File \'%s\' not found', $filename));
		}

		$this->filename = $filename;

		if (!$this->checkAndCreate()) {
			throw new InvalidArgumentException(sprintf('File \'%s\' not found', $filename));
		}
	}

	/**
	 * @return bool
	 */
	private function checkAndCreate(): bool
	{
		if (file_exists($this->filename)) {
			return true;
		}

		return touch($this->filename);
	}

	/**
	 * @param string $data
	 * @param string $metadata
	 *
	 * @return bool
	 */
	public function add(string $data, string $metadata): bool
	{
		$content = $this->load();
		$isSet = false;

		if (!empty($content)) {
			$current = explode(PHP_EOL, $content);
			$result  = array_map(function ($value) use ($metadata, &$isSet) {
				if ($end = mb_strpos($value, ']')) {
					if (($currentMetadata = mb_substr($value, 1, $end - 1)) && $currentMetadata === $metadata) {
						$isSet = true;
						return '[' . $metadata . ']' . mb_substr($value, $end + 1);
					}
				}

				return $value;

			}, $current );
		} else {
			$result = [];
		}

		if (!$isSet) {
			$result[] = '[' . $metadata . ']' . $data;
		}

		return file_put_contents($this->filename, implode(PHP_EOL, $result));
	}

	/**
	 * @return string
	 */
	public function load(): string
	{
		return file_get_contents($this->filename);
	}

	/**
	 * @return array
	 */
	public function toArray(): array
	{
		$content = $this->load();
		if (empty($content)) {
			return [];
		}

		$result = [];
		$current = explode(PHP_EOL, $content);

		foreach ($current as $data) {
			$result[] = mb_substr($data, mb_strpos($data, ']') + 1);
		}

		return $result;
	}

	/**
	 * @param string $metadata
	 *
	 * @return bool
	 */
	public function delete(string $metadata): bool
	{
		$content = $this->load();
		if (empty($content)) {
			return false;
		}

		$current = explode(PHP_EOL, $content);
		$isRemoved = false;
		foreach ($current as $key => $value) {
			if ($end = mb_strpos($value, ']')) {
				if (($currentMetadata = mb_substr($value, 1, $end - 1)) && $currentMetadata === $metadata) {
					unset($current[$key]);
					$isRemoved = true;
					break;
				}
			}
		}

		if ($isRemoved) {
			return file_put_contents($this->filename, implode(PHP_EOL, $current));
		}

		return false;
	}
}