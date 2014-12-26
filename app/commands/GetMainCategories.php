<?php

use Goutte\Client;
use Jyggen\Curl\Curl;
use Illuminate\Console\Command;

class GetMainCategories extends Command {

	/**
	 * The console command name.
	 *
	 * @var string
	 */
	protected $name = 'wwen:get-main-categories';

	/**
	 * The console command description.
	 *
	 * @var string
	 */
	protected $description = 'Gets the main categories from the WWEN.';

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
		$mainCategoryUrls = $this->urlConfig;
		foreach ($mainCategoryUrls as $name => $categoryUrl) {
			$this->info("$name: $categoryUrl");
			$json = $this->getJsonArrayFromUrl($categoryUrl);
			$category = Category::firstOrNew(array(
				'contentId' => $json['contentId']
			));

			$category->type = $json['type'];
			$category->state = isset($json['state']) ? $json['state'] : null; // state field isn't in all categories
			$category->userDate = $json['userDate'];
			$category->title = $json['title'];
			$category->key = $json['key'];
			$category->url = $json['url'];
			$category->seo_headline = $json['seo-headline'];
			$category->save();
		}
	}

	public function getJsonArrayFromUrl($url)
	{
		$rawJson = Curl::get($url);
		$json = json_decode($rawJson[0]->getContent(), true);
		return $json;
	}
}
