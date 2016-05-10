<?php namespace Gooeypress\Presenters;

use Laracasts\Presenter\Presenter;

class ThemePresenter extends Presenter{

    public function ratingStars()
    {
        $html = '<span class="rating"> <!-- Give an additional class of rating_unrated where applicable -->';
        for($i = 0; $i < 5; $i++){
            $html .= $i < $this->rating
                ?  '<span class="icon-star"></span>'
                : '<span class="icon-star rating_unrated"></span>';
        }
        $html .= '</span>';
        return $html;
    }

    public function url()
    {
        $string = $this->title;
        //Unwanted:  {UPPERCASE} ; / ? : @ & = + $ , . ! ~ * ' ( )
        $string = strtolower($string);
        //Strip any unwanted characters
        $string = preg_replace("/[^a-z0-9_\s-]/", "", $string);
        //Clean multiple dashes or whitespaces
        $string = preg_replace("/[\s-]+/", " ", $string);
        //Convert whitespaces and underscore to dash
        $string = preg_replace("/[\s_]/", "-", $string);
        return sprintf('/theme/%s/%s', $this->hash, $string);
    }
}
