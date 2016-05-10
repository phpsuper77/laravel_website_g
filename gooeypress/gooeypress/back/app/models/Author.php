<?php

class Author extends Eloquent{
	/**
	 * The database table used by the model.
	 *
	 * @var string
	 */
	protected $table = 'authors';

    protected $fillable = array('name');
}
