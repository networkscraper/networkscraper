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

    public function getMilestoneArray()
    {
		$this->urlConfig = Config::get('urls');
		$metaDataUrl = $this->urlConfig['video'];
		$metaDataUrl = sprintf($metaDataUrl, $this->media_playback_id);
		$rawMetaData = Curl::get($metaDataUrl);

		$pattern = '/\<milestones(.*?)milestones\>/s';
		preg_match($pattern, $rawMetaData[0], $matches);

		$milestoneXml = $matches[0];
		$milestoneXml = str_replace ('\n', '',  $milestoneXml );
		$milestoneXml = str_replace ('\\', '',  $milestoneXml );

		$xml = simplexml_load_string($milestoneXml);
		$json = json_encode($xml);
		$array = json_decode($json,TRUE);

		return $array;

    }
}
