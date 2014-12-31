<?php

use Jyggen\Curl\Curl;
use Illuminate\Console\Command;

class GetEpisodesForShows extends Command {

	/**
	 * The console command name.
	 *
	 * @var string
	 */
	protected $name = 'wwen:get-episodes-for-shows';

	/**
	 * The console command description.
	 *
	 * @var string
	 */
	protected $description = 'Gets episode info for shows.';

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
		$shows = Show::all();
		foreach ($shows as $show) {
			$this->comment("Show: {$show->show_name}");
			$showDetailsUrl = $this->constructShowDetailsUrl($show);
			$episodeDetails = $this->getEpisodedetails($showDetailsUrl);
			$this->insertOrUpdateEpisodeDetails($episodeDetails, $show->contentId);
		}
	}

	private function constructShowDetailsUrl($show)
	{
		$showDetailsUrl = $this->urlConfig['episdoes'];
		$showDetailsUrl = sprintf($showDetailsUrl, $show->show_name);
		return $showDetailsUrl;
	}

	private function getEpisodedetails($url)
	{
		$rawJson = Curl::get($url);
		$json = json_decode($rawJson[0]->getContent(), true);
		return $json;
		// dd($json['list'][1]['headline']);

	}

	private function insertOrUpdateEpisodeDetails($episodeDetails, $showId)
	{
		$index = 0;

		foreach ($episodeDetails['list'] as $episodeDetails) {
			if ($index != 0) {
				echo $episodeDetails['headline'] . "\n";
				$episode = Episode::firstOrNew(array(
					'contentId' => $episodeDetails['contentId']
				));

				$episode->type    = $episodeDetails['type'];
				$episode->state	    = $episodeDetails['state'];
				$episode->contentId    = $episodeDetails['contentId'];
				$episode->shows_id    = $showId;
				$episode->userDate    = $episodeDetails['userDate'];
				$episode->kicker	    = $episodeDetails['kicker'];
				$episode->headline	    = $episodeDetails['headline'];
				$episode->guid	    = $episodeDetails['guid'];
				$episode->blurb	    = $episodeDetails['blurb'];
				$episode->sequence	    = $episodeDetails['sequence'];
				$episode->feature_context    = $episodeDetails['feature-context'];
				$episode->notes	    = $episodeDetails['notes'];
				$episode->delivery_type	    = $episodeDetails['delivery-type'];
				$episode->namespace	    = $episodeDetails['namespace'];
				$episode->bigblurb	    = $episodeDetails['bigblurb'];
				$episode->duration    = $episodeDetails['duration'];
				$episode->secure    = $episodeDetails['secure'];
				$episode->show_name    = $episodeDetails['show_name'];
				$episode->series_name	    = $episodeDetails['series_name'];
				$episode->franchise    = $episodeDetails['franchise'];
				$episode->venue_name	    = $episodeDetails['venue_name'];
				$episode->genre    = $episodeDetails['genre'];
				$episode->advisory_rating    = $episodeDetails['advisory_rating'];
	

				$episode->venue_location	 = isset($episodeDetails['itemTags']['venue_location'][0]) ? $episodeDetails['itemTags']['venue_location'][0] : null; // not all episodes have venue_location
				$episode->active = $episodeDetails['itemTags']['active'][0];
				$episode->tv_rating = $episodeDetails['itemTags']['tv_rating'][0];
				$episode->searchable = $episodeDetails['itemTags']['searchable'][0];
				$episode->air_date	 = $episodeDetails['itemTags']['air_date'][0];
				$episode->media_playback_id			 = $episodeDetails['itemTags']['media_playback_id'][0];
				$episode->milestones_xml	 =  isset($episodeDetails['itemTags']['milestones_xml'][0]) ? $episodeDetails['itemTags']['milestones_xml'][0] : null; // not all episodes have milestones

				;
				$episode->subject	 = $episodeDetails['itemTags']['subject'][0];
				$episode->expiration_date	 =  isset($episodeDetails['itemTags']['expiration_date'][0]) ? $episodeDetails['itemTags']['expiration_date'][0] : null; // not all episodes have expiration_date
				$episode->release_date	 = isset($episodeDetails['itemTags']['release_date'][0]) ? $episodeDetails['itemTags']['release_date'][0] : null; // not all episodes have release_date

				$episode->event_date	 = isset($episodeDetails['itemTags']['event_date'][0]) ? $episodeDetails['itemTags']['event_date'][0] : null; // not all episodes have event_date

				$episode->save();
			}
			
			$index++;
		}
	}
}
