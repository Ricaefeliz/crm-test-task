<?php

declare(strict_types=1);

namespace App\Customer;


/**
 * Class CustomerFacade
 * @package App\Customer
 */
final class CustomerFacade
{


	/** @var CustomerRepository */
	private $customerRepo;



	/**
	 * CustomerFacade constructor.
	 * @param CustomerRepository $customerRepo
	 */
	public function __construct(CustomerRepository $customerRepo)
	{
		$this->customerRepo = $customerRepo;
	}



	/**
	 * @return int
	 */
	public function getCount(): int
	{
		return $this->customerRepo->count([]);
	}
}