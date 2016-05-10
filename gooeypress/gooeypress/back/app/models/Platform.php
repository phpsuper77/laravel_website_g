<?php

class Platform extends Eloquent{
	/**
	 * The database table used by the model.
	 *
	 * @var string
	 */
	protected $table = 'platforms';

    protected $fillable = array('name', 'url');
}
