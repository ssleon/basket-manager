<?php

namespace App\Infrastructure\Command;


use App\Application\Service\Tactic\Request\ListTacticRequest;
use Exception;
use Symfony\Component\Console\Helper\Table;
use Symfony\Component\Console\Helper\TableCell;
use Symfony\Component\Console\Helper\TableSeparator;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;

/**
 * Class ListTacticCommand
 *
 * @package App\Infrastructure\Command
 */
class ListTacticCommand extends AbstractCommand
{
	/**
	 *
	 */
	const NAME = 'basket-manager:tactic:list';

	/**
	 * {@inheritdoc}
	 */
	protected function configure()
	{
		$this
			->setName(static::NAME)
			->setDescription('List team tactics');
	}

	/**
	 * {@inheritdoc}
	 */
	protected function execute(InputInterface $input, OutputInterface $output)
	{
		try {

			$result = $this->serviceBus->handle(
				new ListTacticRequest()
			);

		} catch (Exception $e) {

			$output->writeln(sprintf('<error>%s</error>', $e->getMessage()));
			exit;

		}

		if (!empty($result)) {
			array_unshift($result, new TableSeparator());
		}

		$defaultTactics = $this->normalizeDefaultTactics();

		(new Table($output))
			->setHeaders([
				[new TableCell('Tactic list', ['colspan' => 6])],
				['Name', 'Role position 1', 'Role position 2', 'Role position 3', 'Role position 4', 'Role position 5']
			])
			->setRows(array_merge($defaultTactics, $result))
			->render();
	}

	/**
	 * @return array
	 */
	private function normalizeDefaultTactics(): array
	{
		$result = [];
		foreach ($this->defaultTactics as $tactic) {
			$row = $tactic['positions'];
			array_unshift($row, $tactic['name']);
			$result[] = $row;
		}

		return $result;
	}
}