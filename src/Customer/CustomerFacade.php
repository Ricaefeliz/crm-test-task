<?php

declare(strict_types=1);

namespace App\Customer;


use App\Order\OrderRepository;
use Doctrine\ORM\EntityManager;
use Doctrine\ORM\ORMException;


/**
 * Class CustomerFacade
 * @package App\Customer
 */
final class CustomerFacade
{


	/** @var CustomerRepository */
	private $customerRepo;

	/** @var EntityManager */
	private $entityManager;

	/** @var OrderRepository */
	private $orderRepo;



	/**
	 * CustomerFacade constructor.
	 * @param CustomerRepository $customerRepo
	 * @param EntityManager $entityManager
	 * @param OrderRepository $orderRepo
	 */
	public function __construct(CustomerRepository $customerRepo,
								EntityManager $entityManager,
								OrderRepository $orderRepo)
	{
		$this->customerRepo = $customerRepo;
		$this->entityManager = $entityManager;
		$this->orderRepo = $orderRepo;
	}



	/**
	 * @param $name string
	 * @param $surname string
	 * @param $address string
	 * @param $email string
	 * @param $telephone string
	 * @return Customer
	 * @throws CustomerFacadeException
	 * @throws ORMException
	 * @throws \Exception
	 */
	public function add(string $name,
						string $surname,
						string $address,
						string $email,
						string $telephone): Customer
	{
		try {
			$this->customerRepo->getOneByEmail($email);
			throw new CustomerFacadeException(sprintf('Customer with e-mail \'%s\' exists already.', $email));
		} catch (CustomerNotFoundException $e) {
		}

		$customer = new Customer($name, $surname, $address, $email, $telephone);
		$this->entityManager->persist($customer);
		$this->entityManager->flush();

		return $customer;
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
		$revenues = $this->orderRepo->findHighestCustomerRevenue($limit);
		if ($revenues) {
			$customers = $this->customerRepo->findByMoreId(array_keys($revenues));
			foreach ($revenues as $customerId => $revenue) {
				$customersDTO[] = new CustomerDTO($customers[$customerId], (float)$revenue);
			}
		}
		return $customersDTO;
	}
}