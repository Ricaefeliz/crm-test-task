<?php

declare(strict_types=1);

namespace App\Order;

use App\Card\Card;
use App\Customer\Customer;
use App\Order\Item\Item;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\ORM\Mapping as ORM;
use Doctrine\ORM\PersistentCollection;
use Kdyby\Doctrine\Entities\Attributes\Identifier;


/**
 * @package App\Order
 * @ORM\Table(name="`order`")
 * @ORM\Entity(repositoryClass="App\Order\OrderRepository")
 */
class Order
{


	use Identifier;

	/**
	 * @var Customer
	 * @ORM\ManyToOne(targetEntity="App\Customer\Customer")
	 */
	protected $customer;

	/**
	 * @var Card
	 * @ORM\ManyToOne(targetEntity="App\Card\Card")
	 */
	protected $card;

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
	 * @var float
	 * @ORM\Column(type="decimal", precision=19, scale=4)
	 */
	protected $priceSummary;

	/**
	 * @var \DateTime
	 * @ORM\Column(type="datetime")
	 */
	protected $createdAt;

	/**
	 * @var ArrayCollection|PersistentCollection|Item[]
	 * @ORM\OneToMany(targetEntity="App\Order\Item\Item", mappedBy="order", cascade={"persist", "remove"})
	 */
	protected $items;



	/**
	 * Order constructor.
	 * @param Customer $customer
	 * @param Card $card
	 * @param string $name
	 * @param string $surname
	 * @param float $priceSummary
	 * @throws \Exception
	 */
	public function __construct(Customer $customer,
								Card $card,
								string $name,
								string $surname,
								float $priceSummary)
	{
		$this->customer = $customer;
		$this->card = $card;
		$this->name = $name;
		$this->surname = $surname;
		$this->priceSummary = $priceSummary;
		$this->createdAt = new \DateTime();
		$this->items = new ArrayCollection();
	}



	/**
	 * @return Customer
	 */
	public function getCustomer(): Customer
	{
		return $this->customer;
	}



	/**
	 * @return Card
	 */
	public function getCard(): Card
	{
		return $this->card;
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
	 * @return float
	 */
	public function getPriceSummary(): float
	{
		return $this->priceSummary;
	}



	/**
	 * @return \DateTime
	 */
	public function getCreatedAt(): \DateTime
	{
		return $this->createdAt;
	}



	/**
	 * @param $item Item
	 * @return void
	 */
	public function addItem(Item $item)
	{
		$this->items->add($item);
		$this->priceSummary += $item->getPrice();
	}



	/**
	 * @return ArrayCollection|PersistentCollection|Item[]
	*/
	public function getItems()
	{
		return $this->items;
	}
}