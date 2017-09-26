<?php

namespace OrckidLab\LaravelTaxonomy\Traits;

use OrckidLab\LaravelTaxonomy\Models\Term;

/**
 * Trait OneToOneTerm
 * @package OrckidLab\LaravelTaxonomy\Traits
 */
trait HasTerm
{
	/**
	 * @param $column
	 * @return mixed
	 */
	public function getTermRelationship($column)
	{
		return $this->hasOne(Term::class, 'id', $column);
	}

	/**
	 * @param $column
	 * @return mixed
	 */
	public function getTerm($column)
	{
		return $this->getTermRelationship($column)->first();
	}

	/**
	 * @param $attribute
	 * @return mixed
	 */
	public function termGetter($attribute)
	{
		$pattern = '/^term/';

		if (preg_match($pattern, $attribute)) {
			$attribute = snake_case(preg_replace($pattern, '', $attribute));

			return $this->getTerm($attribute);
		}

		return null;
	}

	/**
	 * @param $method
	 * @param $parameters
	 * @return mixed
	 */
	public function termCall($method, $parameters)
	{
		$pattern = '/^term/';

		if (preg_match($pattern, $method)) {
			$method = snake_case(preg_replace($pattern, '', $method));

			return $this->getTermRelationship($method);
		}

		return null;
	}
}