<?php

use Goutte\Client;
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
	
		
/*		$client = new Client();
		$crawler = $client->request('GET', $this->urlConfig['shows']);
		$crawler->filter('.row > .secondary-nav > a')->each(function ($node) {
		    
		});*/

		$client = new Client();
		$crawler = $client->request('GET', 'http://network.wwe.com/video/v31299871');
		$crawler->filter('script')->each(function ($node) {
		    if (strpos($node->text(),'vppConfig') !== false) {

			    $json = $this->extract_unit($node->text(), "vppConfig = {", "var gptAdConfig" );
			    $json = str_replace('\n', '', $json);
			    $json = str_replace("\\", '', $json);
			    $json = json_decode($json);

			    // between <milestones and </milestones>
			}
		});

	}
	private function extract_unit($string, $start, $end)
	{
		$startPos = stripos($string, $start);
		$endPos = stripos($string, $end);

		$result = substr($string, $startPos, $endPos - $startPos);


		return $result;
	}
}
