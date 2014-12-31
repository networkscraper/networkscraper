<?php

use Jyggen\Curl\Curl;
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

		$mainCategoryUrls = $this->urlConfig['categories'];
		foreach ($mainCategoryUrls as $name => $categoryUrl) {
			$this->comment("Category: $name");
			$json = $this->getJsonArrayFromUrl($categoryUrl);
			$arrayOfShows = $json['list'];
			foreach ($arrayOfShows as $showInfo) {
				$this->info("Show: " . $showInfo['title']);
				$show = Show::firstOrNew(array(
					'contentId' => $showInfo['contentId']
				));
				$show->category_id = $json['contentId'];
				$show->type = $showInfo['type'];
				$show->state = isset($showInfo['state']) ? $showInfo['state'] : null;
				$show->userDate = $showInfo['userDate'];
				$show->title = $showInfo['title'];
				$show->show_name = $showInfo['itemTags']['show_name'][0];
				$show->bigblurb = isset($showInfo['bigblurb']) ? $showInfo['bigblurb'] : null;
				$show->url = $showInfo['url'];
				$show->seo_headline = $showInfo['seo-headline'];
				$show->save();
			}
		}
	}

	public function getJsonArrayFromUrl($url)
	{
		$rawJson = Curl::get($url);
		$json = json_decode($rawJson[0]->getContent(), true);
		return $json;
	}
}
