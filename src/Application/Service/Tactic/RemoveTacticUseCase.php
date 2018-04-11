<?php

namespace App\Application\Service\Tactic;


use App\Application\Service\RequestInterface;
use App\Application\Service\Tactic\Request\RemoveTacticRequest;
use LogicException;

/**
 * Class RemoveTacticUseCase
 *
 * @package App\Application\Service\Tactic
 */
class RemoveTacticUseCase extends AbstractTacticUseCase
{
	/**
	 * @param RequestInterface|RemoveTacticRequest $request
	 *
	 * @throws LogicException
	 */
	public function execute(RequestInterface $request): void
	{
		if (!$this->tacticRepository->exist($request->name())) {
			throw new LogicException(sprintf('There is no tactic with name %s', $request->name()));
		}

		$this->tacticRepository->delete($request->name());
	}
}