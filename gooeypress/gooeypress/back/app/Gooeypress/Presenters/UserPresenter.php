<?php namespace Gooeypress\Presenters;

use Laracasts\Presenter\Presenter;

class UserPresenter extends Presenter {

    public function avatar($size = 50)
    {
        $hash = md5(strtolower($this->email));

        return sprintf("//www.gravatar.com/avatar/$hash?size=%d", $size);
    }

}