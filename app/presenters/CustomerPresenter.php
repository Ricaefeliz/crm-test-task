<?php

declare(strict_types=1);

namespace App\Presenters;

use App\Card\CardFacadeFactory;
use App\Components\SearchForm\SearchForm;
use App\Components\SearchForm\SearchFormFactory;
use App\Customer\CustomerFacadeFactory;
use Nette\Application\UI\Presenter;


/**
 * @author Dusan Mlynarcik <dusan.mlynarcik@email.cz>
 */
final class CustomerPresenter extends Presenter
{


	/** @var CardFacadeFactory @inject */
	public $cardFacadeFactory;

	/** @var CustomerFacadeFactory @inject */
	public $customerFacadeFactory;

	/** @var SearchFormFactory @inject */
	public $searchFormFactory;



	/**
	 * @param $query string|null
	 * @return void
	 */
	public function actionSearch(string $query = NULL)
	{
		if ($query !== NULL) {
			$customerFacade = $this->customerFacadeFactory->create();
			$customers = $customerFacade->findByQuery($query);
		}

		$this->template->customers = $customers ?? [];
		$this->template->query = $query;
	}



	/**
	 * @return void
	 */
	public function actionReport()
	{
		$cardFacade = $this->cardFacadeFactory->create();
		$customerFacade = $this->customerFacadeFactory->create();

		$this->template->assignedCardCount = $cardFacade->countAssigned();
		$this->template->customerCount = $customerFacade->getCount();
		$this->template->topCustomers = $customerFacade->findByRevenue();
	}



	/**
	 * @return SearchForm
	 */
	public function createComponentSearchForm(): SearchForm
	{
		return $this->searchFormFactory->create();
	}
}