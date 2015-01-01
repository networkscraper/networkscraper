<?php

use Jyggen\Curl\Curl;

class Episode extends Eloquent
{

	/**
	 * URL config.
	 *
	 * @var array
	 */
	protected $urlConfig;
	/**
	 * The database table used by the model.
	 *
	 * @var string
	 */
	protected $table = 'episodes';
    protected $guarded = array('');
    protected $primaryKey = 'contentId';

    public function show()
    {
        return $this->belongsTo('Show');
    }

	public function milestones()
    {
        return $this->hasMany('Milestone');
    }

    public function getMilestoneJson()
    {
		$this->urlConfig = Config::get('urls');
		$metaDataUrl = $this->urlConfig['video'];
		$metaDataUrl = sprintf($metaDataUrl, $this->media_playback_id);
		$rawMetaData = Curl::get($metaDataUrl);

		$pattern = '/\<milestones(.*?)milestones\>/s';
		preg_match($pattern, $rawMetaData[0], $matches);

		// if no element 0 then there was something wrong with the returned data
		if (!isset($matches[0])) {
			return false;
		}


		$milestoneXml = $matches[0];
		$milestoneXml = str_replace ('\n', '',  $milestoneXml );
		$milestoneXml = str_replace ('\\', '',  $milestoneXml );

		$xml = simplexml_load_string($milestoneXml);
		$json = json_encode($xml);
		$json = json_decode($json, true);
		return $json;


    }
}
