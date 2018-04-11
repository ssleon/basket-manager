<?php

namespace App\Infrastructure\Command;


use App\Application\Service\ServiceBusInterface;
use App\Infrastructure\Util\Assert;
use Symfony\Component\Console\Command\Command;

abstract class AbstractCommand extends Command
{
	/**
	 *
	 */
	const EXPECTED_ROLE_VALUES = ['base', 'escolta', 'alero', 'ala-pivot', 'pivot'];

	/**
	 * @var Assert
	 */
	protected $assert;
	/**
	 * @var ServiceBusInterface
	 */
	protected $serviceBus;
	/**
	 * @var array
	 */
	protected $defaultTactics;

	/**
	 * AbstractCommand constructor
	 *
	 * @param Assert              $assert
	 * @param ServiceBusInterface $commandBus
	 * @param array               $defaultTactics
	 */
	public function __construct(Assert $assert, ServiceBusInterface $commandBus, array $defaultTactics) {
		parent::__construct();

		$this->assert         = $assert;
		$this->serviceBus     = $commandBus;
		$this->defaultTactics = $defaultTactics;
	}
}