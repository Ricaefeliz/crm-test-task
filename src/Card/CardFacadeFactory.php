<?php

declare(strict_types=1);

namespace App\Card;


/**
 * Interface CardFacadeFactory
 * @package App\Card
 */
interface CardFacadeFactory
{


	/**
	 * @return CardFacade
	 */
	public function create();
}