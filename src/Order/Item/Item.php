<?php

declare(strict_types=1);

namespace App\Order\Item;

use App\Order\Order;
use Kdyby\Doctrine\Entities\Attributes\Identifier;


/**
 * Class Item
 * @package App\Order\Item
 */
class Item
{


	use Identifier;

	/**
	 * @var Order
	 * @ORM\OneToOne(targetEntity="App\Order\Order")
	 */
	protected $order;

	/**
	 * @var string
	 * @ORM\Column(type="string", length=50)
	 */
	protected $name;

	/**
	 * @var int
	 * @ORM\Column(type="smallint")
	 */
	protected $quantity;

	/**
	 * @var float
	 * @ORM\Column(type="decimal", precision=19, scale=4)
	 */
	protected $price;



	/**
	 * Item constructor.
	 * @param Order $order
	 * @param string $name
	 * @param int $quantity
	 * @param float $price
	 */
	public function __construct(Order $order,
								string $name,
								int $quantity,
								float $price)
	{
		$this->order = $order;
		$this->name = $name;
		$this->quantity = $quantity;
		$this->price = $price;
	}



	/**
	 * @return Order
	 */
	public function getOrder(): Order
	{
		return $this->order;
	}



	/**
	 * @return string
	 */
	public function getName(): string
	{
		return $this->name;
	}



	/**
	 * @return int
	 */
	public function getQuantity(): int
	{
		return $this->quantity;
	}



	/**
	 * @return float
	 */
	public function getPrice(): float
	{
		return $this->price;
	}


}