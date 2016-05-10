<?php

class Requirement extends Eloquent{
	/**
	 * The database table used by the model.
	 *
	 * @var string
	 */
	protected $table = 'requirements';

    protected $fillable = array('name');
}
