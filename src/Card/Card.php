<?php

declare(strict_types=1);

namespace App\Card;

use App\Customer\Customer;
use Doctrine\ORM\Mapping as ORM;
use Kdyby\Doctrine\Entities\Attributes\Identifier;


/**
 * @package App\Card
 * @ORM\Entity(repositoryClass="App\Card\CardRepository")
 * @ORM\Table(name="number", uniqueConstraints={
 *     @ORM\UniqueConstraint(name="number", columns={"number"})
 *        }
 * )
 */
class Card
{


	use Identifier;

	/** @var string */
	const BASIC_TYPE = 'basic';
	const TEMPORARY_TYPE = 'temporary';

	/**
	 * @var Customer|null
	 * @ORM\OneToOne(targetEntity="App\Customer\Customer")
	 */
	protected $customer;

	/**
	 * @var string
	 * @ORM\Column(type="string", length=10)
	 */
	protected $type;

	/**
	 * @var int
	 * @ORM\Column(type="integer", length=10)
	 */
	protected $number;

	/**
	 * @var \DateTime
	 * @ORM\Column(type="datetime")
	 */
	protected $createdAt;



	public function __construct(int $number, string $type = self::TEMPORARY_TYPE)
	{
		$this->number = $number;
		$this->type = $type;
		$this->createdAt = new \DateTime();
	}



	/**
	 * @param $customer Customer
	 * @throws CustomerAssignedAlreadyException
	 */
	public function setCustomer(Customer $customer)
	{
		if ($this->hasCustomer()) {
			throw new CustomerAssignedAlreadyException('Card has an assigned customer already.');
		}
		$this->customer = $customer;
	}



	/**
	 * @return Customer|null
	 */
	public function getCustomer(): ?Customer
	{
		return $this->customer;
	}



	/**
	 * @return int
	 */
	public function getNumber(): int
	{
		return $this->number;
	}



	/**
	 * @return string
	 */
	public function getType(): string
	{
		return $this->type;
	}



	/**
	 * @return \DateTime
	 */
	public function getCreatedAt(): \DateTime
	{
		return $this->createdAt;
	}



	/**
	 * @return bool
	 */
	public function hasCustomer(): bool
	{
		return $this->getCustomer() instanceof Customer;
	}
}