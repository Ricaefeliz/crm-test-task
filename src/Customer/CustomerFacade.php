<?php

declare(strict_types=1);

namespace App\Customer;


use App\Order\OrderRepository;


/**
 * Class CustomerFacade
 * @package App\Customer
 */
final class CustomerFacade
{


	/** @var CustomerRepository */
	private $customerRepo;

	/** @var OrderRepository */
	private $orderRepo;



	/**
	 * CustomerFacade constructor.
	 * @param CustomerRepository $customerRepo
	 * @param OrderRepository $orderRepo
	 */
	public function __construct(CustomerRepository $customerRepo,
								OrderRepository $orderRepo)
	{
		$this->customerRepo = $customerRepo;
		$this->orderRepo = $orderRepo;
	}



	/**
	 * @return int
	 */
	public function getCount(): int
	{
		return $this->customerRepo->count([]);
	}



	/**
	 * @param $query string
	 * @return Customer[]|array
	 */
	public function findByQuery(string $query): array
	{
		return $this->customerRepo->findByQuery($query);
	}



	/**
	 * @param $limit int
	 * @return CustomerDTO[]|array
	 */
	public function findByRevenue(int $limit = 10): array
	{
		$customersDTO = [];
		$revenue = $this->orderRepo->findHighestCustomerRevenue($limit);
		if ($revenue) {
			$customers = $this->customerRepo->findByMoreId(array_keys($revenue));
			foreach ($revenue as $r) {
				$customersDTO[] = new CustomerDTO($customers[$r['customer']], $r['revenue']);
			}
		}
		return $customersDTO;
	}
}