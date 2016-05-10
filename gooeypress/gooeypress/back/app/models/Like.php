<?php

class Like extends Eloquent{
	/**
	 * The database table used by the model.
	 *
	 * @var string
	 */
	protected $table = 'likes';

    protected $fillable = array('user_id', 'theme_id');

    public static function boot(){
        parent::boot();

        self::created(function($like){
            Activity::create([
                'owner_id' => $like->user_id,
                'theme_id' => $like->theme_id,
                'activity' => 'like'
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
