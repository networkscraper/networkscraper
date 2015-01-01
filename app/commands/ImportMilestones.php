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
		$this->info("Getting all episodes...");
		$allEpisodes = Episode::all();
		$allEpisodes->each(function($episode)
		{
			$this->info("Getting Milestone Json... {$episode->headline}  |  {$episode->media_playback_id}");
			$milestoneJson = $episode->getMilestoneJson();


			if ( isset($milestoneJson['milestone'][0]) && isset($milestoneJson['milestone']))  {

				
				foreach ($milestoneJson['milestone'] as $milestoneData) {

					$milestoneId =  $milestoneData['@attributes']['id'];
					$this->info("Parsing Milestone Data $milestoneId");	



					if (isset($milestoneData['keywords']['keyword'])) {
						foreach ($milestoneData['keywords']['keyword'] as $keyword) {

							$milestone = new Milestone;
							$milestone->milestone_id = $milestoneId;
							$milestone->title = isset($milestoneData['title']) ? $milestoneData['title'] : null; // title field isn't in all milestones
							$milestone->blurb = isset($milestoneData['blurb']) ? $milestoneData['blurb'] : null; // blurb field isn't in all milestones
							$milestone->contentId = $episode->contentId;
							$milestone->type = 	isset($keyword["@attributes"]['type']) ? $keyword["@attributes"]['type'] : null; // type field isn't in all milestones
							$milestone->value = isset($keyword["@attributes"]['value']) ? $keyword["@attributes"]['value'] : null; // value field isn't in all milestones
							$milestone->displayName = isset($keyword["@attributes"]['displayName']) ? $keyword["@attributes"]['displayName'] : null; // displayName field isn't in all milestones
							$this->info("Type: {$milestone->type}: Value: {$milestone->value}");
							$milestone->save();	

						}
					} 

				}
			}
		});
	}
}
