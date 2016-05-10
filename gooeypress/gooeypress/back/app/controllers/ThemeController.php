<?php

use Gooeypress\Services\ThemeSearchFilter;
use Gooeypress\Services\ThemeSearchService;
use Illuminate\Session\Store;
use Illuminate\Http\Request;

class ThemeController extends BaseController {

    private $perpage = 8;

    /**
     * @var Store
     */
    protected $session;

    /**
     * @var Request
     */
    protected $request;

    /**
     * @var ThemeSearchService
     */
    protected $searchService;

    protected $orderBys = [
        'price' => 'price',
        'performance' => 'level_overall',
        'popular' => 'likes_count',
        'recent' => 'updated_at'
    ];

    function __construct(Store $session, Request $request, ThemeSearchService $searchService)
    {
        $this->session = $session;
        $this->request = $request;
        $this->searchService = $searchService;
    }


    public function themes()
    {
        if ($this->request->get('filter'))
        {
            $filter = ThemeSearchFilter::create($this->request->all());

            $builder = $this->searchService->filter($filter);
        } else {
            $builder = Theme::live();
        }

        $orderBy = Input::get('order_by');
        $order = Input::get('order') == 'asc' ? 'asc' : 'desc';

        if($orderBy){
            $themes = $builder->orderBy($this->orderBys[$orderBy], $order)
                ->paginate($this->perpage);
        }else{
            $themes = $builder->paginate($this->perpage);
        }


        return View::make('themes', [
            'themes' => $themes
        ]);
    }

    public function themeDetails($hash, $title)
    {
        $theme = Theme::with('vendor', 'author', 'style', 'genre', 'requirement', 'layouts', 'platform', 'licence')
            ->where('hash', '=', $hash)->first();

        if ('/'.$this->request->path() != $theme->present()->url) {
            return Redirect::to($theme->present()->url, 301);
        }

        $me = Auth::user();
        $like = null;
        $saved = null;

        if ($me != null) {
            $like = Like::where('user_id', '=', $me->id)
                ->where('theme_id', '=', $theme->id)->first();
            $saved = SavedTheme::where('owner_id', '=', $me->id)
                ->where('theme_id', '=', $theme->id)
                ->first();
        }

        $reviews = Review::with('user')->where('theme_id', '=', $theme->id)->get();

        return View::make('theme-detail', [
            'theme'   => $theme,
            'reviews' => $reviews,
            'me'      => $me,
            'like'    => $like,
            'saved'   => $saved,
        ]);
    }

    public function demo($hash)
    {
        $theme = Theme::where('hash', $hash)->first();

        return View::make('themes.demo', [
            'theme' => $theme
        ]);
    }

    public function addThemeRating($hash)
    {
        $theme = Theme::with('vendor', 'author', 'style', 'genre', 'requirement', 'layouts', 'platform', 'licence')
            ->where('hash', '=', $hash)->first();

        $me = Auth::user();

        $review = Review::where('user_id', '=', $me->id)->where('theme_id', '=', $theme->id)->first();

        if ($review == null) {
            $review = Review::create([
                'user_id'  => $me->id,
                'theme_id' => $theme->id,
                'comment'  => Input::get('themeReview'),
                'rating'   => Input::get('rating'),
            ]);
        } else {
            $review->comment = Input::get('themeReview');
            $review->rating = Input::get('rating');

            $review->save();
        }

        $stats = DB::select('SELECT AVG(rating) AS rating, COUNT(user_id) AS rating_count
            FROM reviews WHERE theme_id = ?', [$theme->id])[0];
        DB::update('UPDATE themes SET rating = ?, rating_count = ? WHERE id = ?',
            [$stats->rating, $stats->rating_count, $theme->id]);

        return Redirect::back()->withFlashMessage('Your rating is added');

    }

    public function likeTheme($hash)
    {
        $theme = Theme::where('hash', '=', $hash)->first();
        $me = Auth::user();

        $like = Like::where('user_id', '=', $me->id)
            ->where('theme_id', '=', $theme->id)->first();

        if ($like == null) {
            Like::create([
                'user_id'  => $me->id,
                'theme_id' => $theme->id,
            ]);
            $theme->likes_count += 1;
            $theme->save();
        } else {
            $like->delete();
            $theme->likes_count -= 1;
            $theme->save();
        }
        if ($this->request->ajax()) {
            return Response::json(['status' => 'ok', 'message' => 'Success']);
        } else {
            return Redirect::to($theme->present()->url);
        }
    }

    public function saveTheme($id)
    {
        $theme = Theme::findOrFail($id);
        $me = Auth::user();

        $saved = SavedTheme::firstOrCreate(['owner_id' => $me->id, 'theme_id' => $theme->id]);

        $saved->save();

        return Redirect::back()->with('message', 'Theme saved');
    }

    public function removeTheme($id)
    {
        $theme = Theme::findOrFail($id);
        $me = Auth::user();

        DB::delete('DELETE FROM saved_themes WHERE theme_id = ? AND owner_id = ?', [
            $theme->id, $me->id
        ]);

        return Redirect::back()->with('message', 'Theme removed');
    }
}

; ?>
