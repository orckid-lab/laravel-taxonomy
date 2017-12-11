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
		'slug',
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
	 * @param string $column
	 * @return mixed
	 */
	public function scopeFromTaxonomy($query, $taxonomy, $column = 'slug')
	{
		return $query->whereHas('taxonomy', function ($query) use ($taxonomy, $column) {
			return $query->where($column, $taxonomy);
		});
	}

	/**
	 * @param $value
	 */
	public function setMetaAttribute($value)
	{
		$this->attributes['meta'] = json_encode($value);
	}

	/**
	 * @param $value
	 * @return mixed|null
	 */
	public function getMetaAttribute($value)
	{
		return $value ? json_decode($value) : null;
	}
}
