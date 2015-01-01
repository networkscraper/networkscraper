<?php

use Illuminate\Console\Command;

class ImportMilestones extends BaseCommand {

	/**
	 * The console command name.
	 *
	 * @var string
	 */
	protected $name = 'wwen:import-milestones';

	/**
	 * The console command description.
	 *
	 * @var string
	 */
	protected $description = 'Get milestone data for each episode.';

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
		$allEpisodes = Episode::all();
		$allEpisodes->each(function($episode)
		{
			$milestoneArray = $episode->getMilestoneArray();

			dd($milestoneArray);
		});

	}
}
