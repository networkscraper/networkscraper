<?php

use Illuminate\Console\Command;

class BaseCommand extends Command {

	
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

	

}
