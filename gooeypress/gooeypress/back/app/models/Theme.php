<?php

use Laracasts\Presenter\PresentableTrait;

class Theme extends Eloquent
{
    use PresentableTrait;

    protected $presenter = 'Gooeypress\Presenters\ThemePresenter';

	protected $table = 'themes';

    protected $fillable = array(
        'title',
        'notes',
        'price',
        'price_type',
        'link_purchase',
        'link_demo',
        'level',
        'style_id',
        'genre_id',
        'vendor_id',
        'author_id',
        'requirement_id',
        'default_layout_id',
        'responsive',
        'platform_id',
        'licence_id',
        'state',
        'publication_status',
    );
    public static function boot(){
        parent::boot();

        self::observe(new ThemeObserver);
    }

    public function scopeLive()
    {
        return $this->where('state', '=', 'ready')
            ->where('publication_status', '=', 'published');
    }

    public function setStyleIdAttribute($value)
    {
        $this->attributes['style_id'] = $value ? $value : null;
    }
    public function setGenreIdAttribute($value)
    {
        $this->attributes['genre_id'] = $value ? $value : null;
    }
    public function setAuthorIdAttribute($value)
    {
        $this->attributes['author_id'] = $value ? $value : null;
    }
    public function setVendorIdAttribute($value)
    {
        $this->attributes['vendor_id'] = $value ? $value : null;
    }
    public function setPlatformIdAttribute($value)
    {
        $this->attributes['platform_id'] = $value ? $value : null;
    }
    public function setLicenceIdAttribute($value)
    {
        $this->attributes['licence_id'] = $value ? $value : null;
    }
    public function setDefaultLayoutIdAttribute($value)
    {
        $this->attributes['default_layout_id'] = $value ? $value : null;
    }

    static public function completed(){
        return self::where('n_complete', '>=', 14)->count();
    }

    public function isCompleted(){
        return $this->getNComplete() == 14;
    }

    public function getNComplete()
    {
        $n = 0;
        if($this->style_id > 0) $n++;
        if($this->genre_id > 0) $n++;
        if($this->vendor_id > 0) $n++;
        if($this->requirement_id > 0) $n++;
        if($this->default_layout_id > 0) $n++;

        if($this->licence_id > 0) $n++;
        if($this->platform_id > 0) $n++;
        if($this->responsive != 'none') $n++;

        if(trim($this->title) != '') $n++;
        if(trim($this->notes) != '') $n++;
        if($this->level != 'none') $n++;
        if(trim($this->link_purchase) != '') $n++;
        if(trim($this->link_demo) != '') $n++;

        if($this->price_type != 'none'){
            $n++;
        }

        return $n;
    }

    public function layouts()
    {
        return $this->belongsToMany('Layout');
    }
    public function vendor()
    {
        return $this->belongsTo('Vendor', 'vendor_id', 'id');
    }
    public function author()
    {
        return $this->belongsTo('Author', 'author_id', 'id');
    }
    public function requirement()
    {
        return $this->belongsTo('Requirement', 'requirement_id', 'id');
    }
    public function style()
    {
        return $this->belongsTo('Style', 'style_id', 'id');
    }
    public function genre()
    {
        return $this->belongsTo('Genre', 'genre_id', 'id');
    }
    public function platform()
    {
        return $this->belongsTo('Platform', 'platform_id', 'id');
    }
    public function licence()
    {
        return $this->belongsTo('Licence', 'licence_id', 'id');
    }

    public function savedByUsers(){
        return $this->belongsToMany('User', 'saved_themes', 'theme_id', 'owner_id');
    }

    public function likedByUsers()
    {
        return $this->belongsToMany('User', 'likes', 'theme_id', 'user_id');
    }
}

class ThemeObserver{
    public function saving($theme){
        if($theme->state == 'draft' && $theme->isCompleted()){
            $theme->state = 'completed';
            if($theme->screenshot != '' && $theme->yslow != ''){
                $theme->state = 'ready';
            }
        }
    }

    public function saved($theme)
    {
        if($theme->state == 'ready')
        {
            Event::fire('theme.ThemeBecameReady', $theme);
        }
    }
}
