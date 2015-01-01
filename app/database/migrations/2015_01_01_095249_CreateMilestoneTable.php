<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateMilestoneTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('milestones', function($table)
		{
			$table->integer('id');	
			$table->integer('contentId'); // link to episode
			$table->string('title')->nullable();	
			$table->string('blurb', 500)->nullable();	
			$table->string('type')->nullable();	
			$table->string('value')->nullable();
			$table->string('displayName')->nullable();	
			$table->timestamps();


			$table->primary('id');	
		});
	}

	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down()
	{
		Schema::drop('milestones');
	}

}
