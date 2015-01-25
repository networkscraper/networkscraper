<?php

class Milestone extends Eloquent
{

	/**
	 * The database table used by the model.
	 *
	 * @var string
	 */
	protected $table = 'milestones';
    protected $guarded = array('');
    protected $primaryKey = 'id';

    public function episode()
    {
        return $this->belongsTo('Episode','contentId');
    }

    public function talent()
    {
		return $this->belongsToMany('Talent', 'milestones_talent', 'id', 'talent_id');
    }
}
