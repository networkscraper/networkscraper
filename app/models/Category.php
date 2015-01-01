<?php

class Category extends Eloquent
{

	/**
	 * The database table used by the model.
	 *
	 * @var string
	 */
	protected $table = 'categories';
    protected $guarded = array('');
    protected $primaryKey = 'contentId';

    public function shows()
    {
        return $this->hasMany('Show');
    }
}
