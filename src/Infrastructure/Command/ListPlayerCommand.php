<?php

namespace App\Infrastructure\Command;


use App\Application\Service\Player\Request\ListPlayerRequest;
use Exception;
use Symfony\Component\Console\Helper\Table;
use Symfony\Component\Console\Helper\TableCell;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;

/**
 * Class ListPlayerCommand
 *
 * @package App\Infrastructure\Command
 */
class ListPlayerCommand extends AbstractCommand
{
	/**
	 *
	 */
	const EXPECTED_ORDER_BY_VALUES   = ['number', 'role-avg'];
	/**
	 *
	 */
	const EXPECTED_ORDER_TYPE_VALUES = ['desc', 'asc'];
	/**
	 *
	 */
	const NAME = 'basket-manager:player:list';

	/**
	 * {@inheritdoc}
	 */
	protected function configure()
	{
		$this
			->setName(static::NAME)
			->setHelp('Command args order: ' . static::NAME . ' [order-by] [order-type]')
			->setDescription('List players with sorting options')
			->addArgument('order-by', InputArgument::OPTIONAL, 'Order by: [number|role-avg]', 'number')
			->addArgument('order-type', InputArgument::OPTIONAL, 'Order type: [desc|asc]', 'desc');
	}

	/**
	 * {@inheritdoc}
	 */
	protected function execute(InputInterface $input, OutputInterface $output)
	{
		$orderBy = strtolower($input->getArgument('order-by'));
		$this->assert->valueIn($orderBy, 'Order by', static::EXPECTED_ORDER_BY_VALUES);

		$orderType = strtolower($input->getArgument('order-type'));
		$this->assert->valueIn($orderType, 'Order type', static::EXPECTED_ORDER_TYPE_VALUES);

		try {

			$result = $this->serviceBus->handle(
				new ListPlayerRequest($orderBy, $orderType)
			);

		} catch (Exception $e) {

			$output->writeln(sprintf('<error>%s</error>', $e->getMessage()));
			exit;

		}

		$output->writeln(sprintf('Player list ordered by \'%s %s\'', $orderBy, $orderType));
		(new Table($output))
			->setHeaders([
				[new TableCell(sprintf('Player list ordered by \'%s %s\'', $orderBy, $orderType), ['colspan' => 4])],
				['Dorsal number', 'Name', 'Role within the team', 'Average rating']
			])
			->setRows($result)
			->render();
	}
}