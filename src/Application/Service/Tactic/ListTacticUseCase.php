<?php

namespace App\Application\Service\Tactic;


use App\Application\Service\RequestInterface;
use App\Application\Service\Tactic\Request\ListTacticRequest;
use App\Domain\Model\Entity\Tactic;

/**
 * Class ListTacticUseCase
 *
 * @package App\Application\Service\Tactic
 */
class ListTacticUseCase extends AbstractTacticUseCase
{
	/**
	 * @param RequestInterface|ListTacticRequest $request
	 *
	 * @return array
	 */
	public function execute(RequestInterface $request): array
	{
		$current = $this->tacticRepository->getAll();

		$result = [];
		/** @var Tactic $tactic */
		foreach ($current as $tactic) {
			$data = $tactic->toArray();
			$row = $data['positions'];
			array_unshift($row, $data['name']);
			$result[] = $row;
		}

		return $result;
	}
}