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
	 * @param $name
	 * @return \Illuminate\Database\Eloquent\Builder|static
	 */
	public static function find($name)
	{
		return self::instance()->load($name);
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
	 * @param $name
	 * @return $this
	 */
	public function load($name)
	{
		$this->group = Taxonomy::where('name', $name)->firstOrFail();

		return $this;
	}

	/**
	 * @param $name
	 * @return $this
	 */
	public static function create($name)
	{
		return (new static)->make($name);
	}

	/**
	 * @param $name
	 * @return $this
	 */
	public function make($name)
	{
		$this->group = new Taxonomy;

		$this->group->name = $name;

		$this->group->save();

		return $this;
	}

	/**
	 * @param array|Term $option
	 * @return $this
	 */
	public function add($option)
	{
		if(is_array($option)){
			$option = new Term($option);
		}

		$this->group->terms()->save($option);

		return $this;
	}

	/**
	 * @param $options
	 * @return $this
	 */
	public function addMany($options)
	{
		$this->group->terms()->saveMany($options);

		return $this;
	}

	/**
	 * @return mixed
	 */
	public function get()
	{
		return $this->group->options;
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

			Route::resource('term', $namespace . 'TermController', [
				'except' => [
					'index'
				]
			]);
		});
	}
}