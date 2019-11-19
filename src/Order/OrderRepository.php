<?php

declare(strict_types=1);

namespace App\Order;

use Doctrine\Common\Collections\Criteria;
use Doctrine\ORM\EntityRepository;


/**
 * Class OrderRepository
 * @package App\Order
 */
class OrderRepository extends EntityRepository
{


	/**
	 * @param $limit int
	 * @return array
	 */
	public function findHighestCustomerRevenue(int $limit = 10): array
	{
		$list = [];
		$result = $this->_em->createQueryBuilder()
			->select('customer, SUM(priceSummary) AS revenue')
			->from(Order::class, 'order')
			->addGroupBy('customer')
			->setMaxResults(10)
			->orderBy('revenue', Criteria::DESC)
			->getQuery()
			->getArrayResult();

		foreach ($result as $value) {
			$list[$value['customer']] = $value['revenue'];
		}

		return $list;
	}
}