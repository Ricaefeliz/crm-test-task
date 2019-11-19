<?php

declare(strict_types=1);

namespace App\Components\RegistrationForm;

use App\Card\CardFacade;
use App\Card\CardFacadeException;
use App\Card\CardFacadeFactory;
use App\Customer\CustomerFacade;
use App\Customer\CustomerFacadeException;
use App\Customer\CustomerFacadeFactory;
use Doctrine\ORM\EntityManager;
use Nette\Application\AbortException;
use Nette\Application\UI\Control;
use Nette\Application\UI\Form;


/**
 * Class RegistrationForm
 * @package App\Components\RegistrationForm
 */
final class RegistrationForm extends Control
{


	/** @var CardFacade */
	private $cardFacade;

	/** @var CustomerFacade */
	private $customerFacade;

	/** @var EntityManager */
	private $entityManager;



	public function __construct(CardFacadeFactory $cardFacadeFactory,
								CustomerFacadeFactory $customerFacadeFactory,
								EntityManager $entityManager)
	{
		parent::__construct();
		$this->cardFacade = $cardFacadeFactory->create();
		$this->customerFacade = $customerFacadeFactory->create();
		$this->entityManager = $entityManager;
	}



	/**
	 * @return Form
	 */
	public function createComponentForm(): Form
	{
		$form = new Form();
		$form->addText('name', 'Name*')
			->setRequired('Fill the name')
			->setMaxLength(50);
		$form->addText('surname', 'Surname*')
			->setRequired('Fill the surname')
			->setMaxLength(50);
		$form->addText('address', 'Address*')
			->setRequired('Fill the address')
			->setMaxLength(100);
		$form->addText('email', 'E-mail*')
			->setRequired('Fill the e-mail')
			->setMaxLength(50)
			->addRule(Form::EMAIL, 'E-mail does not have a valid format');
		$form->addText('telephone', 'Telephone*')
			->setRequired('Fill the telephone')
			->setMaxLength(20);
		$form->addSelect('card', 'Card*', $this->getCardList())
			->setPrompt('-select-')
			->setRequired('Choose a card');
		$form->addSubmit('submit', 'Register');
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
		$values = $form->getValues();
		$presenter = $this->getPresenter();

		try {
			$this->entityManager->beginTransaction();
			$customer = $this->customerFacade->add($values->name, $values->surname, $values->address, $values->email, $values->telephone);
			$this->cardFacade->assignCustomer($values->card, $customer->getId());
			$this->entityManager->commit();

			$presenter->flashMessage('Customer has been registered.', 'success');
			$presenter->redirect('this');
		} catch (CustomerFacadeException | CardFacadeException $exception) {
			$this->entityManager->rollback();
			$presenter->flashMessage($exception->getMessage(), 'danger');
		}
	}



	public function render()
	{
		$this->template->setFile(__DIR__ . '/template.latte');
		$this->template->render();
	}



	/**
	 * @return array
	 */
	private function getCardList(): array
	{
		$list = [];
		$cards = $this->cardFacade->findWithoutCustomer();
		foreach ($cards as $card) {
			$list[$card->getId()] = $card->getNumber();
		}
		return $list;
	}
}