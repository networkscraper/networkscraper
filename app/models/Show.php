<?php

class Show extends Eloquent
{

	/**
	 * The database table used by the model.
	 *
	 * @var string
	 */
	protected $table = 'shows';
    protected $guarded = array('');
    protected $primaryKey = 'contentId';

    public function category()
    {
        return $this->belongsTo('Category');
    }

	public function episodes()
    {
        return $this->hasMany('Episode', 'shows_id');
    }

}
