<?php

namespace App\Presenters;

use App\Components\RegistrationForm\RegistrationForm;
use App\Components\RegistrationForm\RegistrationFormFactory;
use Nette;


/**
 * Class RegistrationPresenter
 * @package App\Presenters
 */
final class RegistrationPresenter extends Nette\Application\UI\Presenter
{


	/** @var RegistrationFormFactory @inject */
	public $formFactory;



	/**
	 * @return RegistrationForm
	 */
	public function createComponentForm(): RegistrationForm
	{
		return $this->formFactory->create();
	}
}
