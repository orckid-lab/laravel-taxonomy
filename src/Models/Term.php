<?php

namespace OrckidLab\LaravelTaxonomy\Models;

use Illuminate\Database\Eloquent\Model;

/**
 * Class FormOption
 * @package App
 */
class Term extends Model
{
	/**
	 * @var array
	 */
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
	 * @param $query
	 * @param $taxonomy
	 * @return mixed
	 */
	public function scopeFromTaxonomy($query, $taxonomy)
	{
		return $query->whereHas('taxonomy', function ($query) use ($taxonomy) {
			return $query->where('name', $taxonomy);
		});
	}

	/**
	 * @param $value
	 */
	public function setMetaAttribute($value)
	{
		$this->attributes['meta'] = json_encode($value);
	}
}
