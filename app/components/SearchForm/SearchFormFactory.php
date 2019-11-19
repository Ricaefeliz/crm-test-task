<?php

declare(strict_types=1);

namespace App\Components\SearchForm;

/**
 * @author Dusan Mlynarcik <dusan.mlynarcik@email.cz>
 */
interface SearchFormFactory
{


	/**
	 * @return SearchForm
	 */
	public function create();
}