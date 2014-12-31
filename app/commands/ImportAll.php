<?php

use Illuminate\Console\Command;

class ImportAll extends BaseCommand {

	/**
	 * The console command name.
	 *
	 * @var string
	 */
	protected $name = 'wwen:import-all';

	/**
	 * The console command description.
	 *
	 * @var string
	 */
	protected $description = 'Runs all import commands.';

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
		$this->call('wwen:get-main-categories');
		$this->call('wwen:get-shows-for-categories');
		$this->call('wwen:get-episodes-for-shows');
	}
}
