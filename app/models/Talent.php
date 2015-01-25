<?php

class Talent extends Eloquent
{

	/**
	 * The database table used by the model.
	 *
	 * @var string
	 */
	protected $table = 'talent';
    protected $guarded = array('');
    protected $primaryKey = 'talent_id';

	public function milestones()
    {
        return $this->belongsToMany('Milestone', 'milestones_talent', 'talent_id', 'milestone_id');
    }
}
