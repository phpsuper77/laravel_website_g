<?php

use Illuminate\Auth\UserInterface;
use Illuminate\Auth\Reminders\RemindableInterface;
use Laracasts\Presenter\PresentableTrait;

class User extends Eloquent implements UserInterface, RemindableInterface {

	use PresentableTrait;

	protected $presenter = 'Gooeypress\Presenters\UserPresenter';

	/**
	 * The database table used by the model.
	 *
	 * @var string
	 */
	protected $table = 'users';

	/**
	 * The attributes excluded from the model's JSON form.
	 *
	 * @var array
	 */
	protected $hidden = array('password');

    protected $fillable = ['email', 'username', 'nickname', 'role', 'password',
        'location', 'website', 'first_name', 'last_name', 'bio', 'email_preference'];

    public function isAdmin(){
        return 'admin' == $this->role;
    }

    public function getEmailPreferenceAttribute(){
        $pref = $this->attributes['email_preference'];
        $pref = $pref == ''
            ? '{"updates":true, "products" : true, "free_themes": true, "recommendations": true, "blog": true, "give_aways": true }'
            : $pref;
        return json_decode($pref);
    }
    public function setEmailPreferenceAttribute($pref){
        $this->attributes['email_preference'] = json_encode($pref);
    }

	/**
	 * Get the unique identifier for the user.
	 *
	 * @return mixed
	 */
	public function getAuthIdentifier()
	{
		return $this->getKey();
	}

	/**
	 * Get the password for the user.
	 *
	 * @return string
	 */
	public function getAuthPassword()
	{
		return $this->password;
	}

	/**
	 * Get the token value for the "remember me" session.
	 *
	 * @return string
	 */
	public function getRememberToken()
	{
		return $this->remember_token;
	}

	/**
	 * Set the token value for the "remember me" session.
	 *
	 * @param  string  $value
	 * @return void
	 */
	public function setRememberToken($value)
	{
		$this->remember_token = $value;
	}

	/**
	 * Get the column name for the "remember me" token.
	 *
	 * @return string
	 */
	public function getRememberTokenName()
	{
		return 'remember_token';
	}

	/**
	 * Get the e-mail address where password reminders are sent.
	 *
	 * @return string
	 */
	public function getReminderEmail()
	{
		return $this->email;
	}

    public function savedThemes(){
        return $this->belongsToMany('Theme', 'saved_themes', 'owner_id', 'theme_id')->orderBy('saved_themes.created_at', 'desc');
    }

    public function activities(){
        return $this->hasMany('Activity', 'owner_id', 'id')->orderBy('created_at', 'desc');
    }

}
