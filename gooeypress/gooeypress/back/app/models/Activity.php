<?php

class Activity extends Eloquent{
	/**
	 * The database table used by the model.
	 *
	 * @var string
	 */
	protected $table = 'activities';

    protected $fillable = array('owner_id', 'theme_id', 'activity');

    public function theme()
    {
        return $this->belongsTo('Theme', 'theme_id', 'id');
    }
    public function owner()
    {
        return $this->belongsTo('User', 'owner_id', 'id');
    }

    public function icon(){
        $icon = 'heart';
        switch($this->activity){
        case 'rate': $icon = 'star'; break;
        case 'save': $icon = 'pin' ; break;
        case 'like':
        default:
            $icon = 'heart';
        }
        return $icon;
    }
}
