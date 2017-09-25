<?php

namespace OrckidLab\LaravelTaxonomy\View;

use OrckidLab\LaravelTaxonomy\Models\Taxonomy;

/**
 * Class TaxonomyView
 * @package OrckidLab\LaravelTaxonomy\View
 */
abstract class TaxonomyView
{
	/**
	 * @var Taxonomy
	 */
	protected $taxonomy;

	/**
	 * @var string
	 */
	protected $edit;

	/**
	 * TaxonomyView constructor.
	 * @param Taxonomy $taxonomy
	 */
	public function __construct(Taxonomy $taxonomy)
	{
		$this->taxonomy = $taxonomy;
	}

	/**
	 * @param $array
	 * @param $array2
	 * @return array
	 */
	protected function merge($array, $array2)
	{
		return array_merge($array, $array2);
	}

	/**
	 * @return $this
	 */
	public function edit()
	{
		return view($this->edit)->with($this->customData());
	}

	public function customData()
	{
		return $this->merge([
			'taxonomy' => $this->taxonomy,
			'terms' => $this->taxonomy->terms()->orderBy('order', 'asc')->get(),
		], method_exists($this, 'data') ? $this->data() : []);
	}
}