<?php

class SavedTheme extends Eloquent{
	/**
	 * The database table used by the model.
	 *
	 * @var string
	 */
	protected $table = 'saved_themes';

    protected $fillable = array('owner_id', 'theme_id');

    public static function boot(){
        parent::boot();

        self::created(function($savedTheme){
            Activity::create([
                'owner_id' => $savedTheme->owner_id,
                'theme_id' => $savedTheme->theme_id,
                'activity' => 'save'
            ]);
        });
    }

    public function theme()
    {
        return $this->belongsTo('Theme', 'theme_id', 'id');
    }
    public function user()
    {
        return $this->belongsTo('User', 'owner_id', 'id');
    }
}
