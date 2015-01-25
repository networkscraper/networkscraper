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
        return $this->belongsToMany('Milestone', 'milestones_talent', 'talent_id', 'id');
    }

    public function getMatchStartMilestones()
    {
    	 $milestones = $this->milestones()->get();

    	 $milestones = $milestones->toArray();

    	 $milestonesIdArray = [];
    	 foreach ($milestones as $milestone) {
    	 	$milestonesIdArray[] = $milestone['milestone_id'];
    	 }


    	 $matchStartMilestones = Milestone::with('Episode')
    	 									->where('value', '=', 'match_start')
    	 									->whereIn('milestone_id', $milestonesIdArray)
    	 									->get();

    	 return $matchStartMilestones->toArray();
    }
}
