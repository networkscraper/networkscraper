<?php

use Illuminate\Console\Command;

class GetShowsForCategories extends Command {

	/**
	 * The console command name.
	 *
	 * @var string
	 */
	protected $name = 'wwen:get-shows-for-categories';

	/**
	 * The console command description.
	 *
	 * @var string
	 */
	protected $description = 'Gets shows for each main category';

	/**
	 * Create a new command instance.
	 *
	 * @return void
	 */
	public function __construct()
	{
		parent::__construct();
	}

	/**
	 * Execute the console command.
	 *
	 * @return mixed
	 */
	public function fire()
	{
		$categories = Category::all();

		foreach ($categories as $category) {

		}

	}
}
