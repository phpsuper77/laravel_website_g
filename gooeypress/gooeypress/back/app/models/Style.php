<?php

class Style extends Eloquent{
	/**
	 * The database table used by the model.
	 *
	 * @var string
	 */
	protected $table = 'styles';

    protected $fillable = array('name');
}
