<?php

declare(strict_types=1);

namespace App\Components\SearchForm;

use Nette\Application\AbortException;
use Nette\Application\UI\Control;
use Nette\Application\UI\Form;


/**
 * Class SearchForm
 * @package App\Components\SearchForm
 */
final class SearchForm extends Control
{


	/**
	 * @return Form
	 */
	public function createComponentForm(): Form
	{
		$form = new Form();
		$form->addText('query', 'Query*')
			->setRequired('Fill the query.');
		$form->addSubmit('submit', 'Search');
		$form->onSuccess[] = [$this, 'formSuccess'];

		return $form;
	}



	/**
	 * @param $form Form
	 * @return void
	 * @throws AbortException
	 */
	public function formSuccess(Form $form)
	{
		$this->getPresenter()
			->redirect('Customer:search', [
				'query' => $form->getValues()->query,
			]);
	}



	public function render()
	{
		$this->template->setFile(__DIR__ . '/template.latte');
		$this->template->render();
	}
}