<?php

declare(strict_types=1);

namespace App\Customer;

use Doctrine\ORM\EntityRepository;


/**
 * Class CustomerRepository
 * @package App\Customer
 */
class CustomerRepository extends EntityRepository
{


	/**
	 * @param $id int
	 * @return Customer
	 * @throws CustomerNotFoundException
	 */
	public function getOneById(int $id): Customer
	{
		$customer = $this->findBy([
			'id' => $id,
		]);

		if (!$customer) {
			throw new CustomerNotFoundException('Customer not found.');
		}

		return $customer;
	}



	/**
	 * @param $id array
	 * @return Customer[]|array
	 */
	public function findByMoreId(array $id): array
	{
		return $this->findBy([
			'id' => $id,
		]);
	}



	/**
	 * @param $query string
	 * @return Customer[]|array
	 */
	public function findByQuery(string $query): array
	{
		$qb = $this->createQueryBuilder('c');
		return $qb
			->where('c.name LIKE :query')
			->orWhere()
			->where('c.surname LIKE :query')
			->orWhere()
			->where($qb->expr()->in(
				'c.id',
				$this->createQueryBuilder('card')
					->select('card.customer')
					->from('Card', 'Card')
					->where('card.id = :query')
					->getDQL()
			))
			->setParameter('query', '%' . $query . '%')
			->getQuery()
			->getResult();
	}
}