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
	protected $group;

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
		$this->group = Taxonomy::where('slug', $slug)->firstOrFail();

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
		$this->group = new Taxonomy;

		$this->group->label = $label;

		$this->group->slug = !$slug ? str_slug($label) : $slug;

		$this->group->save();

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

		$this->group->terms()->save($term);

		return $this;
	}

	/**
	 * @param $terms
	 * @return $this
	 */
	public function addMany($terms)
	{
		$this->group->terms()->saveMany($terms);

		return $this;
	}

	/**
	 * @return mixed
	 */
	public function get()
	{
		return $this->group->terms;
	}

	/**
	 * @return \Illuminate\Support\Collection
	 */
	public function pluck()
	{
		return $this->group->terms()->pluck('label', 'id');
	}

	/**
	 * @return array
	 */
	public function values()
	{
		return $this->group->terms()->pluck('id')->all();
	}

	/**
	 * @return mixed
	 */
	public function terms()
	{
		return $this->group->terms;
	}

	/**
	 * @return \Illuminate\Database\Eloquent\Collection|static[]
	 */
	public static function all()
	{
		return Taxonomy::all();
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