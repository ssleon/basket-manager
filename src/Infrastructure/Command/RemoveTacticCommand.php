<?php

namespace App\Infrastructure\Command;


use App\Application\Service\Tactic\Request\RemoveTacticRequest;
use Exception;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;

/**
 * Class RemoveTacticCommand
 *
 * @package App\Infrastructure\Command
 */
class RemoveTacticCommand extends AbstractCommand
{
	/**
	 *
	 */
	const NAME = 'basket-manager:tactic:remove';

	/**
	 * {@inheritdoc}
	 */
	protected function configure()
	{
		$this
			->setName(static::NAME)
			->setHelp('Command args order: ' . static::NAME . ' [name]')
			->setDescription('Delete a tactic by name')
			->setHelp('This command allows you to remove a tactic')
			->addArgument('name', InputArgument::REQUIRED, 'Tactic name');
	}

	/**
	 * {@inheritdoc}
	 */
	protected function execute(InputInterface $input, OutputInterface $output)
	{
		$name = $input->getArgument('name');

		try {

			$this->serviceBus->handle(
				new RemoveTacticRequest($name)
			);

		} catch (Exception $e) {

			$output->writeln(sprintf('<error>%s</error>', $e->getMessage()));
			exit;

		}

		$output->writeln(
			sprintf('<info>Tactic \'%s\' was deleted</info>', $name)
		);
	}
}