<?php namespace Gooeypress\Composers;

use Genre;
use Gooeypress\Services\ThemeSearchFilter;
use Illuminate\Http\Request;
use Illuminate\Session\Store;
use Illuminate\View\View;
use Layout;
use Style;

class MainActionsComposer {

    function __construct()
    {
    }

    public function compose(View $view)
    {
        $genres = Genre::all();
        $styles = Style::all();
        $layouts = Layout::all();

        $view->with([
            'genres' => $genres,
            'styles' => $styles,
            'layouts' => $layouts
        ]);
    }


}