<?php

namespace App\Infrastructure\Command;


use App\Application\Service\Player\Request\RemovePlayerRequest;
use Exception;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;

/**
 * Class RemovePlayerCommand
 *
 * @package App\Infrastructure\Command
 */
class RemovePlayerCommand extends AbstractCommand
{
	/**
	 *
	 */
	const NAME = 'basket-manager:player:remove';

	/**
	 * {@inheritdoc}
	 */
	protected function configure()
	{
		$this
			->setName(static::NAME)
			->setHelp('Command args order: ' . static::NAME . ' [number]')
			->setDescription('Delete a player by dorsal number')
			->setHelp('This command allows you to remove a player')
			->addArgument('number', InputArgument::REQUIRED, 'Dorsal number');
	}

	/**
	 * {@inheritdoc}
	 */
	protected function execute(InputInterface $input, OutputInterface $output)
	{
		$number = $input->getArgument('number');
		$this->assert->numeric($number, 'Dorsal number');

		try {

			$this->serviceBus->handle(
				new RemovePlayerRequest($number)
			);

		} catch (Exception $e) {

			$output->writeln(sprintf('<error>%s</error>', $e->getMessage()));
			exit;

		}

		$output->writeln(
			sprintf('<info>Player with dorsal number \'%d\' was deleted</info>', $number)
		);
	}
}