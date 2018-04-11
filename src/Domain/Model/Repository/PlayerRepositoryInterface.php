<?php

namespace App\Domain\Model\Repository;


use App\Domain\Model\Entity\Player;
use App\Domain\Model\Value\DorsalValue;

/**
 * Interface PlayerRepositoryInterface
 *
 * @package App\Domain\Model\Repository
 */
interface PlayerRepositoryInterface {
	/**
	 * @param Player $player
	 *
	 * @return mixed
	 */
	public function save(Player $player): bool;

	/**
	 * @return Player[]
	 */
	public function getAll(): array;

	/**
	 * @param DorsalValue $number
	 *
	 * @return Player|null
	 */
	public function getOne(DorsalValue $number): ?Player;

	/**
	 * @param DorsalValue $number
	 *
	 * @return bool
	 */
	public function exist(DorsalValue $number): bool;

	/**
	 * @param DorsalValue $number
	 *
	 * @return bool
	 */
	public function delete(DorsalValue $number): bool;
}