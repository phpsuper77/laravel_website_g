<?php namespace Gooeypress\Composers;

use Genre;
use Gooeypress\Services\ThemeSearchFilter;
use Illuminate\Http\Request;
use Illuminate\Session\Store;
use Illuminate\View\View;
use Layout;
use Style;

class FiltersComposer {

    protected $session;

    protected $request;

    function __construct(Store $session, Request $request)
    {
        $this->session = $session;
        $this->request = $request;
    }


    public function compose(View $view)
    {
        $searchFilter = ThemeSearchFilter::create($this->request->all());

        $all_prices = ThemeSearchFilter::getPrices();

        $prices = []; $layouts = [];
        $responsives = []; $genres = [];
        $styles = []; $features = [];
        $performances = [];

        if($searchFilter)
        {
            $prices = $searchFilter->price;
            $layouts = $searchFilter->layout;
            $responsives = $searchFilter->responsive;
            $genres = $searchFilter->genre;
            $styles = $searchFilter->style;
            $features = $searchFilter->features;
            $performances = $searchFilter->performance;
        }

        $items = $this->getMenuItems();

        $view->with(compact('items', 'all_prices', 'prices', 'layouts', 'responsives',
            'genres', 'styles', 'features', 'performances'))->with('searchFilter', $searchFilter);
    }

    protected function getMenuItems()
    {
        return [
            'layouts' => Layout::all()->toArray(),
            'genres' => Genre::all()->toArray(),
            'styles' => Style::all()->toArray(),
        ];
    }

}