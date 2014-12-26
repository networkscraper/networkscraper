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
		Schema::table('categories', function($table)
		{
			$table->string('type');	
			$table->string('state');	
		    $table->integer('contentId');
		    $table->time('userDate')
			$table->string('title', 100);	
			$table->string('bigblurb', 500);	
			$table->string('url', 100);	
			$table->string('seo-headline', 100);	
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
