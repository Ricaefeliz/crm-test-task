<?php

declare(strict_types=1);

namespace App\Customer;


/**
 * Class CustomerDTO
 * @package App\Customer
 */
class CustomerDTO
{


	/** @var Customer */
	protected $customer;

	/** @var float */
	protected $revenue;



	public function __construct(Customer $customer, float $revenue)
	{
		$this->customer = $customer;
		$this->revenue = $revenue;
	}



	/**
	 * @return Customer
	 */
	public function getCustomer(): Customer
	{
		return $this->customer;
	}



	/**
	 * @return float
	 */
	public function getRevenue(): float
	{
		return $this->revenue;
	}


}