<?php

class Review extends Eloquent{
	/**
	 * The database table used by the model.
	 *
	 * @var string
	 */
	protected $table = 'reviews';

    protected $fillable = array('user_id', 'theme_id', 'comment', 'rating');

    public static function boot(){
        parent::boot();

        self::created(function($review){
            Activity::create([
                'owner_id' => $review->user_id,
                'theme_id' => $review->theme_id,
                'activity' => 'rate'
            ]);
        });
    }

    public function theme()
    {
        return $this->belongsTo('Theme', 'theme_id', 'id');
    }
    public function user()
    {
        return $this->belongsTo('User', 'user_id', 'id');
    }
}
