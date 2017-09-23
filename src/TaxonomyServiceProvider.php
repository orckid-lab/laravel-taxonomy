<?php

namespace OrckidLab\LaravelTaxonomy;

use Illuminate\Support\ServiceProvider;

/**
 * Class TaxonomyServiceProvider
 * @package OrckidLab\LaravelTaxonomy
 */
class TaxonomyServiceProvider extends ServiceProvider
{
	/**
	 *
	 */
	public function boot()
	{
		$this->loadMigrationsFrom(__DIR__ . '/../migrations');

		$this->loadViewsFrom(__DIR__ . '/../views', 'taxonomy');
	}
}