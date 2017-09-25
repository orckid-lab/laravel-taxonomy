<?php

namespace OrckidLab\LaravelTaxonomy\View;

use OrckidLab\LaravelTaxonomy\Models\Taxonomy;
use OrckidLab\LaravelTaxonomy\Models\Term;

/**
 * Class TermView
 * @package OrckidLab\LaravelTaxonomy\View
 */
class TermView
{
	/**
	 * @var Taxonomy
	 */
	protected $taxonomy;

	/**
	 * @var Term
	 */
	protected $term;

	/**
	 * @var
	 */
	protected $edit;

	/**
	 * TermView constructor.
	 * @param Taxonomy $taxonomy
	 */
	public function __construct(Taxonomy $taxonomy, Term $term)
	{
		$this->taxonomy = $taxonomy;
		$this->term = $term;
	}

	/**
	 * @return $this
	 */
	public function edit()
	{
		return view($this->edit)->with([
			'taxonomy' => $this->taxonomy,
			'term' => $this->term
		]);
	}
}