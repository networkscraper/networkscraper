<?php

class Episode extends Eloquent
{

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
}
