<?php

declare(strict_types=1);

namespace App\Customer;

use App\Card\Card;
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
		$customer = $this->findOneBy([
			'id' => $id,
		]);

		if (!$customer) {
			throw new CustomerNotFoundException('Customer not found.');
		}

		return $customer;
	}



	/**
	 * @param $email string
	 * @return Customer
	 * @throws CustomerNotFoundException
	*/
	public function getOneByEmail(string $email): Customer
	{
		$customer = $this->findOneBy([
			'email' => $email,
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
		$qb = $this->createQueryBuilder('c', 'c.id');
		return $qb
			->where($qb->expr()->in('c.id', $id))
			->getQuery()
			->getResult();
	}



	/**
	 * @param $query string
	 * @return Customer[]|array
	 */
	public function findByQuery(string $query): array
	{
		$qb = $this->createQueryBuilder('c');
		$subQuery = $this->getEntityManager()
			->createQueryBuilder()
			->select('IDENTITY(card.customer)')
			->from(Card::class, 'card')
			->where('card.number LIKE :query')
			->getDQL();
		$where = $qb->expr()->orX(
			$qb->expr()->like('c.name', ':query'),
			$qb->expr()->like('c.surname', ':query'),
			$qb->expr()->in('c.id', $subQuery)
		);

		return $qb
			->andWhere($where)
			->setParameter('query', '%' . $query . '%')
			->getQuery()
			->getResult();
	}
}