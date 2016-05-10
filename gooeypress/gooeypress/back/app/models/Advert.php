<?php

class Advert extends Eloquent
{
	protected $table = 'adverts';

    protected $fillable = array(
        'type',
        'owner_id',
        'theme_id',
        'impression_budget',
        'impressions',
        'clicks',
        'price',
        'qty',
        'gross',
        'payed_amount',
        'status',
        'name',
        'advert_image_url',
    );

    public function layouts()
    {
        return $this->belongsToMany('Layout');
    }
    public function owner()
    {
        return $this->belongsTo('User', 'owner_id', 'id');
    }
    public function theme()
    {
        return $this->belongsTo('Theme', 'theme_id', 'id');
    }
}
