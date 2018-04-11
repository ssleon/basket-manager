<?php

namespace App\Infrastructure\Command;


use App\Application\Service\Tactic\Request\CalculateAlignmentRequest;
use Exception;
use Symfony\Component\Console\Helper\Table;
use Symfony\Component\Console\Helper\TableCell;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;

/**
 * Class CalculateAlignmentCommand
 *
 * @package App\Infrastructure\Command
 */
class CalculateAlignmentCommand extends AbstractCommand {
	/**
	 *
	 */
	const NAME = 'basket-manager:tactic:calculate-alignment';

	/**
	 * {@inheritdoc}
	 */
	protected function configure()
	{
		$this
			->setName(static::NAME)
			->setHelp('Command args order: ' . static::NAME . ' [tactic-name]')
			->setDescription('Calculate the best alignment for given tactic')
			->addArgument('tactic-name', InputArgument::REQUIRED, 'Tactic\'s name');
	}

	/**
	 * {@inheritdoc}
	 */
	protected function execute(InputInterface $input, OutputInterface $output)
	{
		$tacticName = $input->getArgument('tactic-name');

		try {

			$result = $this->serviceBus->handle(
				new CalculateAlignmentRequest($tacticName, $this->defaultTactics)
			);

		} catch (Exception $e) {

			$output->writeln(sprintf('<error>%s</error>', $e->getMessage()));
			exit;

		}

		if ('ok' !== $result['status']) {
			$output->writeln(
				sprintf(
					'<comment>Can\'t apply tactic \'%s\', no player was found with role \'%s\'</comment>',
					$result['tactic'],
					$result['role']
				)
			);
			exit;
		}

		$positions = array_map(function($position) {
			return strtoupper($position);
		}, $result['tactic']->positions());

		(new Table($output))
			->setHeaders([
				[new TableCell(sprintf('The best alignment for \'%s\' tactic', $tacticName), array('colspan' => 5))],
				$positions
			])
			->setRows([$result['alignment']])
			->render();
	}
}