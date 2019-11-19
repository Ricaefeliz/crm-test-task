<?php

declare(strict_types=1);

namespace App\Customer;


/**
 * Interface CustomerFacadeFactory
 * @package App\Customer
 */
interface CustomerFacadeFactory
{


	/**
	 * @return CustomerFacade
	 */
	public function create();
}