<?php

namespace OrckidLab\LaravelTaxonomy\Helpers;

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Fluent;

/**
 * Class AssociateTerm
 * @package OrckidLab\FormOptions\Helpers
 */
class TermForeignColumn
{
	/**
	 * @var Blueprint|string
	 */
	protected $table;

	/**
	 * @var
	 */
	protected $column;

	/**
	 * @var
	 */
	protected $callback;

	/**
	 * AssociateTerm constructor.
	 * @param $column
	 * @param $table
	 */
	public function __construct($column, $table)
	{
		$this->table = $table;

		$this->column = $column;
	}

	/**
	 * @param $column
	 * @param $table
	 * @param \Closure $callback
	 * @return static
	 */
	public static function add($column, $table, \Closure $callback = null)
	{
		$instance = new static($column, $table);

		$instance->setCallback($callback);

		$instance->addForeign();

		return $instance;
	}

	/**
	 * @param $callback
	 */
	public function setCallback($callback)
	{
		$this->callback = $callback;
	}

	public function runCallback(Fluent $column, Fluent $foreign)
	{
		if($this->callback){
			$this->{'callback'}($column, $foreign);
		}

		return $this;
	}

	/**
	 * @return $this
	 */
	protected function addForeign()
	{
		if($this->isBlueprintInstance()){
			$this->runCallback(
				$this->table->integer($this->column)->nullable()->unsigned(),
				$this->table->foreign($this->column)
					->references('id')
					->on('terms')
					->onDelete('set null')
			);

			return $this;
		}

		Schema::table($this->table, function (Blueprint $table) {
			$this->runCallback(
				$table->integer($this->column)->nullable()->unsigned(),
				$table->foreign($this->column)
					->references('id')
					->on('terms')
					->onDelete('set null')
			);
		});

		return $this;
	}

	/**
	 * @param $column
	 * @param $table
	 * @return $this
	 */
	public static function drop($column, $table)
	{
		return self::instance($column, $table)->removeForeign();
	}

	/**
	 * @return $this
	 */
	protected function removeForeign()
	{
		if($this->isBlueprintInstance()){
			$this->table->dropForeign("{$this->table->getTable()}_{$this->column}_foreign");

			$this->table->dropColumn($this->column);

			return $this;
		}

		Schema::table($this->table, function (Blueprint $table) {
			$table->dropForeign("{$this->table}_{$this->column}_foreign");

			$table->dropColumn($this->column);
		});

		return $this;
	}

	/**
	 * @param $column
	 * @param $table
	 * @return static
	 */
	public static function instance($column, $table)
	{
		return new static($column, $table);
	}

	/**
	 * @return bool
	 */
	protected function isBlueprintInstance()
	{
		return $this->table instanceof Blueprint;
	}
}