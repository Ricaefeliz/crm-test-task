<?php

declare(strict_types=1);

namespace App\Card;


use App\Customer\CustomerNotFoundException;
use App\Customer\CustomerRepository;
use Doctrine\ORM\EntityManager;
use Doctrine\ORM\ORMException;


/**
 * Class CardFacade
 * @package App\Card
 */
final class CardFacade
{


	/** @var CardRepository */
	private $cardRepo;

	/** @var CustomerRepository */
	private $customerRepo;

	/** @var EntityManager */
	private $entityManager;



	/**
	 * CardFacade constructor.
	 * @param CardRepository $cardRepo
	 * @param CustomerRepository $customerRepo
	 * @param EntityManager $entityManager
	 */
	public function __construct(CardRepository $cardRepo,
								CustomerRepository $customerRepo,
								EntityManager $entityManager)
	{
		$this->cardRepo = $cardRepo;
		$this->customerRepo = $customerRepo;
		$this->entityManager = $entityManager;
	}



	/**
	 * @param $type string
	 * @param $number int
	 * @return Card
	 * @throws CardFacadeException
	 * @throws ORMException
	 */
	public function add(string $type, int $number): Card
	{
		try {
			$this->cardRepo->getOneByNumber($number);
			throw new CardFacadeException(sprintf('Card with number \'%s\' exists already.', $number));
		} catch (CardNotFoundException $e) {
		}

		try {
			$card = new Card($number, $type);
			$this->entityManager->persist($card);
			$this->entityManager->flush();

			return $card;
		} catch (UnknownTypeException $exception) {
			throw new CardFacadeException($exception->getMessage(), 0, $exception);
		}
	}



	/**
	 * @return Card[]|array
	 */
	public function findWithoutCustomer(): array
	{
		return $this->cardRepo->findWithoutCustomer();
	}



	/**
	 * @return int
	 */
	public function countAssigned(): int
	{
		return $this->cardRepo->countAssigned();
	}



	/**
	 * @param $cardId int
	 * @param $customerId int
	 * @return Card
	 * @throws CardFacadeException
	 * @throws ORMException
	 */
	public function assignCustomer(int $cardId, int $customerId): Card
	{
		try {
			$card = $this->cardRepo->getOneById($cardId);
			$customer = $this->customerRepo->getOneById($customerId);
			$card->setCustomer($customer);
			$this->entityManager->persist($card);
			$this->entityManager->flush();

			return $card;
		} catch (CardNotFoundException | CustomerNotFoundException | CustomerAssignedAlreadyException $exception) {
			throw new CardFacadeException($exception->getMessage(), 0, $exception);
		}
	}
}