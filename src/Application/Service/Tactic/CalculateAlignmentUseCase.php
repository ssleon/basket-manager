<?php

namespace App\Application\Service\Tactic;


use App\Application\Service\RequestInterface;
use App\Application\Service\Tactic\Request\CalculateAlignmentRequest;
use App\Domain\Model\Entity\Player;
use App\Domain\Model\Entity\Tactic;
use LogicException;

/**
 * Class CalculateAlignmentUseCase
 *
 * @package App\Application\Service\Tactic
 */
class CalculateAlignmentUseCase extends AbstractTacticUseCase {
	/**
	 * @param RequestInterface|CalculateAlignmentRequest $request
	 *
	 * @return array
	 * @throws LogicException
	 * @throws \Assert\AssertionFailedException
	 */
	public function execute(RequestInterface $request): array
	{
		$tactic = $this->tacticRepository->getOne($request->tacticName());

		if (null === $tactic) {
			foreach ($request->defaultTactics() as $defaultTactic) {
				if ($request->tacticName() !== $defaultTactic['name']) {
					continue;
				}

				$tactic = Tactic::instance($request->tacticName(), $defaultTactic['positions']);
				break;
			}

			if (null === $tactic) {
				throw new LogicException(sprintf('Tactic with name \'%s\' not exist', $request->tacticName()));
			}
		}

		$players = $this->playerRepository->getAll();
		$alignmentPlayers = [];
		/** @var Player $player */
		foreach ($players as $player) {
			if (!key_exists($player->role(), $alignmentPlayers)) {
				$alignmentPlayers[$player->role()] = [];
			}

			$alignmentPlayers[$player->role()][] = $player;
		}

		foreach ($alignmentPlayers as $role => $players) {

			usort($players, function($player1, $player2) {
				/**
				 * @var Player $player1
				 * @var Player $player2
				 */
				if ($player1->average() === $player2->average()) {
				    return 0;
				}

				return $player1->average() > $player2->average() ? -1 : 1;
			});

			$alignmentPlayers[$role] = $players;

		}

		if (empty($alignmentPlayers)) {
			return [
				'status'    => 'not_role_in_alignment',
				'role'      => $role,
				'tactic'    => (string) $tactic,
				'alignment' => []
			];
		}

		$alignment = [];
		$roleCounter = [];
		foreach ($tactic->positions() as $role) {
			if (empty($alignmentPlayers[$role]) || !array_key_exists($role, $alignmentPlayers)) {
				return [
					'status'    => 'not_role_in_alignment',
					'role'      => sprintf('%s for position %d', $role, $roleCounter[$role] + 1),
					'tactic'    => (string) $tactic,
					'alignment' => []
				];
			}

			$alignment[] =  sprintf(
				'%s (%s) - Avg: %d',
				$alignmentPlayers[$role][0]->name(),
				$alignmentPlayers[$role][0]->number(),
				$alignmentPlayers[$role][0]->average()
			);
			array_shift($alignmentPlayers[$role]);

			if (!isset($roleCounter[$role])) {
				$roleCounter[$role] = 0;
			}

			$roleCounter[$role]++;
		}

		return [
			'status'    => 'ok',
			'role'      => null,
			'tactic'    => $tactic,
			'alignment' => $alignment
		];
	}
}