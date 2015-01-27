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
		//$allEpisodes = Episode::where('media_playback_id' ,'=', 31348419)->get(); //uncomment to just scrape WM 12
		$allEpisodes = Episode::all();
		$allEpisodes->each(function($episode)
		{
			$this->info("Getting Milestone Json... {$episode->headline}  |  {$episode->media_playback_id}");
			$milestoneJson = $episode->getMilestoneJson();

			if (isset($milestoneJson['milestone'][0]) && isset($milestoneJson['milestone']))  {

				
				foreach ($milestoneJson['milestone'] as $milestoneData) {

					$milestoneId =  $milestoneData['@attributes']['id'];
					$this->info("Parsing Milestone Data $milestoneId");	


					if (isset($milestoneData['keywords']['keyword'])) {
						foreach ($milestoneData['keywords']['keyword'] as $keyword) {
							$type = isset($keyword["@attributes"]['type']) ? $keyword["@attributes"]['type'] : null; // type field isn't in all milestones
							$value = isset($keyword["@attributes"]['value']) ? $keyword["@attributes"]['value'] : null; // value field isn't in all milestones

							$milestone = Milestone::firstOrNew(array(
								'milestone_id' => $milestoneId, 
								'contentId' => $episode->contentId,
								'type' => $type,
								'value' => $value)
							);

							$milestone->title = isset($milestoneData['title']) ? $milestoneData['title'] : null; // title field isn't in all milestones
							$milestone->blurb = isset($milestoneData['blurb']) ? $milestoneData['blurb'] : null; // blurb field isn't in all milestones							
											
							$milestone->displayName = isset($keyword["@attributes"]['displayName']) ? $keyword["@attributes"]['displayName'] : null; // displayName field isn't in all milestones
							$this->info("Type: {$milestone->type}: Value: {$milestone->value}");
							$milestone->save();

							if ($type == 'talent') {
								// if it is a talent then we'll save to the talent table
								$talent = Talent::firstOrNew(array('talent_id' => $keyword["@attributes"]['value']));
								$talent->displayName = isset($keyword["@attributes"]['displayName']) ? $keyword["@attributes"]['displayName'] : null;
								$this->info("Type: Talent: Value: {$talent->displayName}  ID: {$talent->talent_id}");
								$talent->milestones()->attach($milestone->id);
								$talent->save();

							} 
						}
					} 

				}
			}
		});
	}
}
