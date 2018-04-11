<?php

namespace App\Infrastructure\Command;


use App\Application\Service\Tactic\Request\CreateTacticRequest;
use Exception;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;

/**
 * Class CreateTacticCommand
 *
 * @package App\Infrastructure\Command
 */
class CreateTacticCommand extends AbstractCommand
{
	/**
	 *
	 */
	const POSITIONS_LIMIT = 5;
	/**
	 *
	 */
	const NAME = 'basket-manager:tactic:create';

	/**
	 * {@inheritdoc}
	 */
	protected function configure()
	{
		$this
			->setName(static::NAME)
			->setHelp('Command args order: ' . static::NAME . ' [name] [position 1] [position 2] ... [position 5]')
			->setDescription('Create a new tactic')
			->addArgument('name', InputArgument::REQUIRED, 'Tactic\'s name')
			->addArgument('positions', InputArgument::IS_ARRAY, 'Positions');
	}

	/**
	 * {@inheritdoc}
	 */
	protected function execute(InputInterface $input, OutputInterface $output)
	{
		$name = $input->getArgument('name');
		$positions = $input->getArgument('positions');
		$this->assert->countEqual($positions, 'positions', static::POSITIONS_LIMIT);
		$this->assert->arrayValueIn($positions, 'position', static::EXPECTED_ROLE_VALUES);

		try {

			$this->serviceBus->handle(
				new CreateTacticRequest($name, $positions)
			);

		} catch (Exception $e) {

			$output->writeln(sprintf('<error>%s</error>', $e->getMessage()));
			exit;

		}

		$output->writeln(
			sprintf('<info>Tactic %s (%s) was created</info>', $name, implode(', ', $positions))
		);
	}
}