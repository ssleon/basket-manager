<?php

namespace App\Application\Service\Tactic;


use App\Application\Service\RequestInterface;
use App\Application\Service\Tactic\Request\CreateTacticRequest;
use App\Application\Service\Tactic\Request\TacticRequestTransform;
use App\Domain\Model\Entity\Tactic;
use LogicException;

/**
 * Class CreateTacticUseCase
 *
 * @package App\Application\Service\Tactic
 */
class CreateTacticUseCase extends AbstractTacticUseCase
{
	/**
	 * @param RequestInterface|CreateTacticRequest $request
	 *
	 * @throws LogicException
	 * @throws \Assert\AssertionFailedException
	 */
	public function execute(RequestInterface $request): void
	{
		if ($this->tacticRepository->exist($request->name())) {
			throw new LogicException(sprintf('There is already a tactic with the name %s', $request->name()));
		}

		$swapObject = new TacticRequestTransform();
		/** @var Tactic $tactic */
		$tactic = $swapObject->transform($request);

		$this->tacticRepository->save($tactic);
	}
}