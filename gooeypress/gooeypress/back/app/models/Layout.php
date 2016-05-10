<?php

class Layout extends Eloquent
{
	protected $table = 'layouts';

    protected $fillable = array('name');

    public function themes()
    {
        return $this->belongsToMany('Theme');
    }
}
