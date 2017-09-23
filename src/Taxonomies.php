<?php

namespace OrckidLab\LaravelTaxonomy;

use Illuminate\Support\Facades\Route;
use OrckidLab\LaravelTaxonomy\Models\Taxonomy;

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
	 * @return mixed
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
	 * @param $option
	 * @return $this
	 */
	public function add($option)
	{
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
	 */
	public static function routes()
	{
		Route::resource('term', '\OrckidLab\LaravelTaxonomy\Controller\TermController', [
			'except' => [
				'index'
			]
		]);

		Route::resource('taxonomy', '\OrckidLab\LaravelTaxonomy\Controller\TaxonomyController', [

		]);
	}
}