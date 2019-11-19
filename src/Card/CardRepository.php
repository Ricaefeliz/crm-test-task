<?php

declare(strict_types=1);

namespace App\Card;

use Doctrine\ORM\EntityRepository;
use Doctrine\ORM\NonUniqueResultException;
use Doctrine\ORM\NoResultException;


/**
 * Class CardRepository
 * @package App\Card
 */
class CardRepository extends EntityRepository
{


	/**
	 * @param $number int
	 * @return Card
	 * @throws CardNotFoundException
	 */
	public function getOneByNumber(int $number): Card
	{
		$card = $this->findOneBy([
			'number' => $number,
		]);

		if (!$card) {
			throw new CardNotFoundException('Card not found.');
		}

		return $card;
	}



	/**
	 * @param $id int
	 * @return Card
	 * @throws CardNotFoundException
	 */
	public function getOneById(int $id): Card
	{
		$card = $this->findOneBy([
			'id' => $id,
		]);

		if (!$card) {
			throw new CardNotFoundException('Card not found.');
		}

		return $card;
	}



	/**
	 * @return Card[]|array
	 */
	public function findWithoutCustomer(): array
	{
		return $this->findBy([
			'customer' => NULL,
		]);
	}



	/**
	 * @return int
	 */
	public function countAssigned(): int
	{
		try {
			$result = (int)$this->createQueryBuilder('c')
				->select('count(c.id)')
				->where('c.customer IS NOT NULL')
				->getQuery()
				->getSingleScalarResult();
		} catch (NoResultException $e) {
		} catch (NonUniqueResultException $e) {
		}

		return $result ?? 0;
	}
}