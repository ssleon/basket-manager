<?php

namespace App\Application\Service\Tactic\Request;


use App\Application\Service\RequestInterface;

/**
 * Class CreateTacticRequest
 *
 * @package App\Application\Service\Tactic\Request
 */
class CreateTacticRequest implements RequestInterface {
	/**
	 * @var string
	 */
	private $name;
	/**
	 * @var array
	 */
	private $positions;

	/**
	 * CreateTacticRequest constructor
	 *
	 * @param string $name
	 * @param array $positions
	 */
	public function __construct( string $name, array $positions ) {
		$this->name      = $name;
		$this->positions = $positions;
	}

	/**
	 * @return string
	 */
	public function name(): string {
		return $this->name;
	}

	/**
	 * @return array
	 */
	public function positions(): array {
		return $this->positions;
	}
}