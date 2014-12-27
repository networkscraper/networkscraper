<?php

use Illuminate\Console\Command;

class GetEpisodesForShows extends Command {

	/**
	 * The console command name.
	 *
	 * @var string
	 */
	protected $name = 'command:name';

	/**
	 * The console command description.
	 *
	 * @var string
	 */
	protected $description = 'Command description.';

	/**
	 * URL config.
	 *
	 * @var array
	 */
	protected $urlConfig;

	/**
	 * Create a new command instance.
	 *
	 * @return void
	 */
	public function __construct()
	{
		$this->urlConfig = Config::get('urls');
		parent::__construct();
	}

	/**
	 * Execute the console command.
	 *
	 * @return mixed
	 */
	public function fire()
	{
		//
	}
}
