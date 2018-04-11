<?php

namespace App\Application\Service\Tactic;


use App\Application\Service\ApplicationServiceInterface;
use App\Domain\Model\Repository\PlayerRepositoryInterface;
use App\Domain\Model\Repository\TacticRepositoryInterface;

/**
 * Class AbstractTacticUseCase
 *
 * @package App\Application\Service\Tactic
 */
abstract class AbstractTacticUseCase implements ApplicationServiceInterface
{
	/**
	 * @var TacticRepositoryInterface
	 */
	protected $tacticRepository;
	/**
	 * @var PlayerRepositoryInterface
	 */
	protected $playerRepository;

	/**
	 * CreatePlayerUseCase constructor
	 *
	 * @param TacticRepositoryInterface $tacticRepository
	 * @param PlayerRepositoryInterface $playerRepository
	 */
	public function __construct(TacticRepositoryInterface $tacticRepository, PlayerRepositoryInterface $playerRepository)
	{
		$this->tacticRepository = $tacticRepository;
		$this->playerRepository = $playerRepository;
	}
}