<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateEpisodesTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('episodes', function($table)
		{
			$table->string('type');	
			$table->string('state')->nullable();	
		    $table->integer('contentId');
		    $table->integer('shows_id'); // episodes belong to a show
		    $table->time('userDate');
			$table->string('kicker', 100);	
			$table->string('headline', 100);	
			$table->string('guid', 100);	
			$table->string('blurb', 100);	
			$table->integer('sequence');	
			$table->string('feature_context', 100);	
			$table->string('notes', 500)->nullable();	
			$table->string('delivery_type', 100);	
			$table->integer('namespace');	
			$table->string('bigblurb', 500);	
			$table->string('duration', 50);	
			$table->string('secure', 1);
			$table->string('show_name', 50);	
			$table->string('series_name', 100);	
			$table->string('franchise', 25);	
			$table->string('venue_name', 150);	
			$table->string('genre', 50);	
			$table->string('advisory_rating', 150);	

			//following are from the itemTags node
			$table->string('venue_location', 150)->nullable();	
			$table->string('active', 10);	
			$table->string('tv_rating', 10);	
			$table->string('searchable', 10);	
			$table->dateTime('air_date');	
			$table->string('media_playback_id', 20);	
			$table->string('milestones_xml', 100)->nullable();	
			$table->string('subject', 100);	
			$table->dateTime('expiration_date')->nullable();
			$table->dateTime('release_date')->nullable();
			$table->dateTime('event_date')->nullable();	

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
		Schema::drop('episodes');
	}

}
