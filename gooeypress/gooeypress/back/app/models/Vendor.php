<?php

class Vendor extends Eloquent{
	/**
	 * The database table used by the model.
	 *
	 * @var string
	 */
	protected $table = 'vendors';

    protected $fillable = array('name');
}
