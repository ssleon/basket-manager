<?php

namespace App\Infrastructure\Command;


use App\Application\Service\Player\Request\CreatePlayerRequest;
use Exception;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;

/**
 * Class CreatePlayerCommand
 *
 * @package App\Infrastructure\Command
 */
class CreatePlayerCommand extends AbstractCommand
{
	/**
	 *
	 */
	const NAME = 'basket-manager:player:create';

	/**
	 * {@inheritdoc}
	 */
	protected function configure()
	{
		$this
			->setName(static::NAME)
			->setHelp('Command args order: ' . static::NAME . ' [name] [number] [role] [average]')
			->setDescription('Create a new player')
			->addArgument('name', InputArgument::REQUIRED, 'Player\'s name')
			->addArgument('number', InputArgument::REQUIRED, 'Dorsal number')
			->addArgument('role', InputArgument::REQUIRED, 'Role in the team: ' . implode(', ', static::EXPECTED_ROLE_VALUES))
			->addArgument('average', InputArgument::REQUIRED, 'Average rating');
	}

	/**
	 * {@inheritdoc}
	 */
	protected function execute(InputInterface $input, OutputInterface $output)
	{
		$number = $input->getArgument('number');
		$this->assert->numeric($number, 'Dorsal number');

		$average = $input->getArgument('average');
		$this->assert->numeric($average, 'Average rating');
		$this->assert->withinRange($average, 'Average rating', 0, 100);

		$role = strtolower($input->getArgument('role'));
		$this->assert->valueIn($role, 'Role within the team', static::EXPECTED_ROLE_VALUES);

		$name = $input->getArgument('name');

		try {

			$this->serviceBus->handle(
				new CreatePlayerRequest($number, $name, $role, $average)
			);

		} catch (Exception $e) {

			$output->writeln(sprintf('<error>%s</error>', $e->getMessage()));
			exit;

		}

		$output->writeln(
			sprintf('<info>Player %s (%d) was created</info>', $name, $number)
		);
	}
}