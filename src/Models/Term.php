<?php

namespace OrckidLab\LaravelTaxonomy\Models;

use Illuminate\Database\Eloquent\Model;

/**
 * Class FormOption
 * @package App
 */
class Term extends Model
{
	protected $fillable = [
		'label',
		'order'
	];

	/**
	 * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
	 */
	public function taxonomy()
	{
		return $this->belongsTo(Taxonomy::class);
	}

	/**
	 * @param $value
	 */
	public function setMetaAttribute($value)
	{
		$this->attributes['meta'] = json_encode($value);
	}
}
