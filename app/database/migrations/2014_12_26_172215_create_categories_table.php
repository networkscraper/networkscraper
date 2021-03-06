<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateCategoriesTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('categories', function($table)
		{
			$table->string('type');	
			$table->string('state')->nullable();	
		    $table->integer('contentId');
		    $table->time('userDate');
			$table->string('title', 100);	
			$table->string('key', 100);	
			$table->string('url', 100);	
			$table->string('seo_headline', 100);	
			$table->timestamps();

			$table->primary('contentId');	
		});
	}

	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down()
	{
		Schema::drop('categories');

	}

}
