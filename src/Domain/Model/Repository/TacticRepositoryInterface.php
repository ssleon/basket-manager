<?php

namespace App\Domain\Model\Repository;


use App\Domain\Model\Entity\Tactic;

/**
 * Interface TacticRepositoryInterface
 *
 * @package App\Domain\Model\Repository
 */
interface TacticRepositoryInterface {
	/**
	 * @param Tactic $tactic
	 *
	 * @return mixed
	 */
	public function save(Tactic $tactic): bool;

	/**
	 * @return mixed
	 */
	public function getAll(): array;

	/**
	 * @param string $name
	 *
	 * @return Tactic
	 */
	public function getOne(string $name): ?Tactic;

	/**
	 * @param string $name
	 *
	 * @return bool
	 */
	public function exist(string $name): bool;

	/**
	 * @param string $name
	 *
	 * @return bool
	 */
	public function delete(string $name): bool;
}