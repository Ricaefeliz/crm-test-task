<?php

declare(strict_types=1);

namespace App\Customer;

use Doctrine\ORM\Mapping as ORM;
use Kdyby\Doctrine\Entities\Attributes\Identifier;


/**
 * @package App\Customer
 * @ORM\Entity(repositoryClass="App\Customer\CustomerRepository")
 */
class Customer
{


	use Identifier;

	/**
	 * @var string
	 * @ORM\Column(type="string", length=50)
	 */
	protected $name;

	/**
	 * @var string
	 * @ORM\Column(type="string", length=50)
	 */
	protected $surname;

	/**
	 * @var string
	 * @ORM\Column(type="string", length=100)
	 */
	protected $address;

	/**
	 * @var string
	 * @ORM\Column(type="string", length=50)
	 */
	protected $email;

	/**
	 * @var string
	 * @ORM\Column(type="string", length=20)
	 */
	protected $telephone;

	/**
	 * @var \DateTime
	 * @ORM\Column(type="datetime")
	 */
	protected $createdAt;



	/**
	 * Customer constructor.
	 * @param string $name
	 * @param string $surname
	 * @param string $address
	 * @param string $email
	 * @param string $telephone
	 * @throws \Exception
	 */
	public function __construct(string $name,
								string $surname,
								string $address,
								string $email,
								string $telephone)
	{
		$this->name = $name;
		$this->surname = $surname;
		$this->address = $address;
		$this->email = $email;
		$this->telephone = $telephone;
		$this->createdAt = new \DateTime();
	}



	/**
	 * @return string
	 */
	public function getName(): string
	{
		return $this->name;
	}



	/**
	 * @return string
	 */
	public function getSurname(): string
	{
		return $this->surname;
	}



	/**
	 * @return string
	 */
	public function getAddress(): string
	{
		return $this->address;
	}



	/**
	 * @return string
	 */
	public function getEmail(): string
	{
		return $this->email;
	}



	/**
	 * @return string
	 */
	public function getTelephone(): string
	{
		return $this->telephone;
	}



	/**
	 * @return \DateTime
	 */
	public function getCreatedAt(): \DateTime
	{
		return $this->createdAt;
	}


}