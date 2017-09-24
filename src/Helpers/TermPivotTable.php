<?php

namespace OrckidLab\LaravelTaxonomy\Helpers;

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

/**
 * Class TermPivotTable
 * @package OrckidLab\LaravelTaxonomy\Helpers
 */
class TermPivotTable
{
	/**
	 * @param $table
	 * @param $localKey
	 * @param $foreignKey
	 * @param $foreignTable
	 */
	public static function create($table, $localKey, $foreignKey, $foreignTable)
	{
		Schema::create($table, function (Blueprint $table) use($localKey, $foreignKey, $foreignTable) {
			$table->integer($localKey)->unsigned();
			$table->integer('term_id')->unsigned();

			$table->foreign($localKey)
				->references($foreignKey)
				->on($foreignTable)
				->onDelete('cascade');

			$table->foreign('term_id')
				->references('id')
				->on('terms')
				->onDelete('cascade');
		});
	}

	/**
	 * @param $table
	 */
	public static function drop($table)
	{
		Schema::dropIfExists($table);
	}
}