<?php

namespace OrckidLab\LaravelTaxonomy\Models;

use Illuminate\Database\Eloquent\Model;

/**
 * Class FormOptionGroup
 * @package App
 */
class Taxonomy extends Model
{
	protected $fillable = [
		'slug',
		'label',
	];

	/**
	 * @return \Illuminate\Database\Eloquent\Relations\HasMany
	 */
	public function terms()
	{
		return $this->hasMany(Term::class);
	}
}
