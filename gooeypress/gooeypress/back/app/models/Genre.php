<?php

class Genre extends Eloquent{
	/**
	 * The database table used by the model.
	 *
	 * @var string
	 */
	protected $table = 'genres';

    protected $fillable = array('name');
}
