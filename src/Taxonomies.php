<?php

namespace OrckidLab\LaravelTaxonomy;

use Illuminate\Support\Facades\Route;
use OrckidLab\LaravelTaxonomy\Models\Taxonomy;
use OrckidLab\LaravelTaxonomy\Models\Term;

/**
 * Class Options
 * @package OrckidLab\LaravelTaxonomy
 */
class Taxonomies
{
	/**
	 * @var Taxonomy
	 */
	protected $taxonomy;

	/**
	 * @return static
	 */
	public static function instance()
	{
		return new static;
	}

	/**
	 * @param $slug
	 * @return \Illuminate\Database\Eloquent\Builder|static
	 */
	public static function find($slug)
	{
		return self::instance()->load($slug);
	}

	/**
	 * @param $term
	 * @param $taxonomy
	 * @param $column
	 */
	public static function findTerm($term, $taxonomy, $column = 'label')
	{
		return Term::where($column, $term)->fromTaxonomy($taxonomy)->first();
	}

	/**
	 * @param $slug
	 * @return $this
	 */
	public function load($slug)
	{
		$this->taxonomy = Taxonomy::where('slug', $slug)->first();

		return $this;
	}

	/**
	 * @param $label
	 * @param $slug
	 * @return $this
	 */
	public static function create($label, $slug = null)
	{
		return (new static)->make($label, $slug);
	}

	/**
	 * @param $label
	 * @param null $slug
	 * @return $this
	 */
	public function make($label, $slug)
	{
		$this->taxonomy = new Taxonomy;

		$this->taxonomy->label = $label;

		$this->taxonomy->slug = !$slug ? str_slug($label) : $slug;

		$this->taxonomy->save();

		return $this;
	}

	/**
	 * @param array|Term $term
	 * @return $this
	 */
	public function add($term)
	{
		if (is_array($term)) {
			$term = new Term($term);

			if (!isset($term['slug'])) {
				$term->slug = str_slug($term->label);
			}
		}

		$this->taxonomy->terms()->save($term);

		return $this;
	}

	/**
	 * @param $terms
	 * @return $this
	 */
	public function addMany($terms)
	{
		$this->taxonomy->terms()->saveMany($terms);

		return $this;
	}

	/**
	 * @return mixed
	 */
	public function get()
	{
		return $this->taxonomy->terms;
	}

	/**
	 * @return \Illuminate\Support\Collection
	 */
	public function pluck()
	{
		return $this->taxonomy->terms()->pluck('label', 'id');
	}

	/**
	 * @return array
	 */
	public function values()
	{
		return $this->taxonomy->terms()->pluck('id')->all();
	}

	/**
	 * @param $slug
	 * @return \Illuminate\Database\Eloquent\Model|null|static
	 */
	public function term($slug)
	{
		return $this->taxonomy->terms()->where('slug', $slug)->first();
	}

	/**
	 * @return mixed
	 */
	public function terms()
	{
		return $this->taxonomy->terms;
	}

	/**
	 * @return \Illuminate\Database\Eloquent\Collection|static[]
	 */
	public static function all()
	{
		return Taxonomy::all();
	}

	/**
	 * @return null
	 */
	public function taxonomy()
	{
		return $this->group;
	}

	/**
	 * @param $attribute
	 * @return null
	 */
	public function __get($attribute)
	{
		if (isset($this->{$attribute})) {
			return $this->{$attribute};
		}

		return null;
	}

	/**
	 * Configure routes for managing form options.
	 * @param string $prefix
	 * @param array $middleware
	 */
	public static function routes($prefix = '', $middleware = [])
	{
		$namespace = '\OrckidLab\LaravelTaxonomy\Controller\\';

		$options = [
			'prefix' => $prefix,
			'middleware' => $middleware
		];

		Route::group($options, function () use ($namespace) {
			Route::resource('taxonomy', $namespace . 'TaxonomyController', [
				'except' => [
					'create',
				]
			]);

			Route::post('taxonomy/{taxonomy}/term', $namespace . 'TermController@store')->name('term.store');

			Route::get('taxonomy/{taxonomy}/term/{term}/edit', $namespace . 'TermController@edit')->name('term.edit');

			//Route::patch('taxonomy/{taxonomy}/term/{term}/update}', $namespace . 'TermController@update')->name('term.update');

			Route::resource('term', $namespace . 'TermController', [
				'only' => [
					'update',
					'destroy'
				]
			]);
		});
	}
}