<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateTermsTable extends Migration
{
	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('terms', function (Blueprint $table) {
			$table->increments('id');
			$table->string('label');
			$table->integer('order');
			$table->json('meta')->nullable();
			$table->integer('taxonomy_id')->unsigned();
			$table->timestamps();

			$table->foreign('taxonomy_id')
				->references('id')
				->on('taxonomies')
				->onDelete('cascade');
		});
	}

	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down()
	{
		Schema::dropIfExists('terms');
	}
}
