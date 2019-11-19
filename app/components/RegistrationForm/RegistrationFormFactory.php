<?php

declare(strict_types=1);

namespace App\Components\RegistrationForm;

/**
 * Interface RegistrationFormFactory
 * @package App\Components\RegistrationForm
 */
interface RegistrationFormFactory
{


	/**
	 * @return RegistrationForm
	 */
	public function create();
}