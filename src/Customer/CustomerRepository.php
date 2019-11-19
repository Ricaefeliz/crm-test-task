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
}