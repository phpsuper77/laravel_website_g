<?php

class Licence extends Eloquent{
	/**
	 * The database table used by the model.
	 *
	 * @var string
	 */
	protected $table = 'licences';

    protected $fillable = array('name', 'url');
}
