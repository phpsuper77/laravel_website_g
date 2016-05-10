<?php

use Illuminate\Http\Request;

class AdmController extends BaseController {

    private $perpage = 20;

    protected $request;

    function __construct(Request $request)
    {
        $this->request = $request;
    }


    public function themeList()
    {
        $total = Theme::all()->count();
        $completed = Theme::where('n_complete', '>=', '12')->count();
        /* Search queries */
        $filter_keys = ['vendor', 'author', 'style', 'genre', 'grade'];

        $filters = Input::only($filter_keys);

        $where = ['1']; $active_fields = [];
        foreach($filters as $key => $value)
        {
            if($value != ''){
                $where[] = sprintf("%s = ?", $key == 'grade' ? 'level' : $key . '_id');
                $active_fields[] = $key;
            }
        }

        $where = join(' AND ', $where);

        $q = trim(Input::get('q'));

        if($q){
            $themes = $this->search($q);
        }else{
            $themes = Theme::with('vendor', 'author')
                ->whereRaw($where, array_values(Input::only($active_fields)))
                ->orderBy('id', 'asc')
                ->paginate($this->perpage);
        }


        /* Show results */
        return View::make('adm.theme.list', array(
            'page_title' => 'Themes',
            'filters' => $filters,
            'themes' => $themes,
            'total' => $total,
            'completed' => $completed,
        ));
    }

    private function search($q)
    {
        $where = ['title LIKE ?', 'notes LIKE ?'];
        $value = ["%$q%", "%$q%"];

        $vendors = Vendor::where('name', 'LIKE', "%$q%")->lists('name', 'id');
        if(count($vendors) > 0){
            $where[] = 'vendor_id IN (?)';
            $value[] = join(',', array_keys($vendors));
        }
        $authors = Author::where('name', 'LIKE', "%$q%")->lists('name', 'id');
        if(count($authors) > 0){
            $where[] = 'author_id IN (?)';
            $value[] = join(',', array_keys($authors));
        }
        $styles = Style::where('name', 'LIKE', "%$q%")->lists('name', 'id');
        if(count($styles) > 0){
            $where[] = 'style_id IN (?)';
            $value[] = join(',', array_keys($styles));
        }
        $genres = Genre::where('name', 'LIKE', "%$q%")->lists('name', 'id');
        if(count($genres) > 0){
            $where[] = 'genre_id IN (?)';
            $value[] = join(',', array_keys($genres));
        }
        $reqs = Requirement::where('name', 'LIKE', "%$q%")->lists('name', 'id');
        if(count($reqs) > 0){
            $where[] = 'requirement_id IN (?)';
            $value[] = join(',', array_keys($reqs));
        }

        return Theme::with('vendor', 'author')
            ->whereRaw(join(' OR ', $where), $value)
            ->orderBy('id', 'asc')
            ->paginate($this->perpage);
    }

	public function showAddThemeForm()
	{
        return View::make('adm.theme.add', array(
            'page_title' => 'Add new theme',
            'vendors' => $this->getVendors(),
            'authors' => $this->getAuthors(),
            'requirements' => $this->getRequirements(),
            'layouts' => $this->getLayouts(),
            'styles' => $this->getStyles(),
            'genres' => $this->getGenres(),
            'licences' => $this->getLicences(),
            'platforms' => $this->getPlatforms(),
        ));
	}
	public function showEditThemeForm($id)
	{
        $theme = Theme::find($id);
        $layouts = DB::select('SELECT * FROM layout_theme WHERE theme_id = ?', array($theme->id));
        $supportedLayouts = array();

        foreach($layouts as $layout){
            $supportedLayouts[$layout->layout_id] = $layout->url;
        }

        return View::make('adm.theme.edit', array(
            'theme' => $theme,
            'page_title' => 'Edit theme: ' . $theme->title,
            'vendors' => $this->getVendors(),
            'authors' => $this->getAuthors(),
            'requirements' => $this->getRequirements(),
            'layouts' => $this->getLayouts(),
            'styles' => $this->getStyles(),
            'genres' => $this->getGenres(),
            'licences' => $this->getLicences(),
            'platforms' => $this->getPlatforms(),

            'supportedLayouts' => $supportedLayouts,
        ));
	}
    public function doAddTheme()
    {
        extract(Input::only('theme', 'layout_url', 'default_layout_id', 'layouts'));

        $lid = intval($default_layout_id);
        $theme['default_layout_id'] = $lid > 0 ? : null;

        foreach(['vendor_id', 'author_id',
            'requirement_id', 'style_id',
            'genre_id', 'platform_id', 'licence_id'] as $key)
        {
            $theme[$key] = $this->request->get($key) ?: null;
        }

        $theTheme = Theme::create($theme);
        $theTheme->n_complete = $theTheme->getNComplete();
        $theTheme->hash = uniqid();
        $theTheme->save();

        foreach($layout_url as $lid => $url)
        {
            $url = trim($url);
            if($url != ''){
                DB::insert('INSERT INTO layout_theme(theme_id, layout_id, url) VALUES (?, ?, ?)',
                    array($theTheme->id, $lid, $url));
            }
        }
        if($theTheme->isCompleted()){
            Queue::push('Gooeypress\Workers\ScreenshotWorker', ['theme_id' => $theTheme->id]);
            Queue::push('Gooeypress\Workers\YSlowWorker', ['theme_id' => $theTheme->id]);
        }

        return Redirect::to('adm/theme/list');
    }
    public function doUpdateTheme($id)
    {
        extract(Input::only('theme', 'layout_url', 'default_layout_id', 'layouts'));

        $lid = intval($default_layout_id);
        $theme['default_layout_id'] = $lid > 0 ? $lid : null;

        var_dump($theme);

        $theTheme = Theme::find($id);
        $theTheme->update($theme);
        $theTheme->n_complete = $theTheme->getNComplete();
        $theTheme->save();

        foreach($layout_url as $lid => $url)
        {
            $url = trim($url);
            if($url != ''){
                if(in_array($lid, $theTheme->layouts->lists('id', 'id'))){
                    DB::update('UPDATE layout_theme SET url = ?
                        WHERE theme_id = ? AND layout_id = ?',
                        array($url, $theTheme->id, $lid));
                }else{
                    DB::insert('INSERT INTO layout_theme(theme_id, layout_id, url)
                        VALUES (?, ?, ?)',
                        array($theTheme->id, $lid, $url));
                }

            }
        }
        if($theTheme->isCompleted()){
            Queue::push('Gooeypress\Workers\ScreenshotWorker', ['theme_id' => $theTheme->id]);
            Queue::push('Gooeypress\Workers\YSlowWorker', ['theme_id' => $theTheme->id]);
        }

        return Redirect::to('adm/theme/list');
    }

    public function deleteTheme($id)
    {
        Theme::find($id)->delete();

        return Redirect::to('adm/theme/list');
    }

    public function styles()
    {
        return Response::json( $this->getStyles() );
    }
    public function doAddStyle()
    {
        $data = Input::only('name');
        $style = Style::create($data);

        return Response::json(array(
            'style' => $style->toArray(),
            'styles' => $this->getStyles()
        ));
    }
    private function getStyles()
    {
        $styles = Style::orderBy('name', 'asc')->get(['id', 'name'])->toArray();

        return array_merge([['id' => '0', 'name' => '- None -']], $styles);
    }

    public function genres()
    {
        return Response::json( $this->getGenres() );
    }
    public function doAddGenre()
    {
        $data = Input::only('name');
        $genre = Genre::create($data);

        return Response::json(array(
            'genre' => $genre->toArray(),
            'genres' => $this->getGenres()
        ));
    }
    private function getGenres()
    {
        $genres = Genre::orderBy('name', 'asc')->get(['id', 'name'])->toArray();

        return array_merge([['id' => '0', 'name' => '- None -']], $genres);
    }

    /* GET /adm/api/vendors */
    public function vendors()
    {
        return Response::json( $this->getVendors() );
    }
    /* POST /adm/api/vendors */
    public function doAddVendor()
    {
        $data = Input::only('name');
        $vendor = Vendor::create($data);

        return Response::json(array(
            'vendor' => $vendor->toArray(),
            'vendors' => $this->getVendors()
        ));
    }
    private function getVendors()
    {
        $vendors = Vendor::orderBy('name', 'asc')->get(['id', 'name'])->toArray();

        return array_merge([['id' => '0', 'name' => '- None -']], $vendors);
    }

    /* GET /adm/api/authors */
    public function authors()
    {
        return Response::json( $this->getAuthors() );
    }
    public function doAddAuthor()
    {
        $data = Input::only('name');
        $author = Author::create($data);

        return Response::json(array(
            'author' => $author->toArray(),
            'authors' => $this->getAuthors()
        ));
    }
    private function getAuthors()
    {
        $authors = Author::orderBy('name', 'asc')->get(['id', 'name'])->toArray();

        return array_merge([['id' => '0', 'name' => '- None -']], $authors);
    }

    public function requirements()
    {
        return Response::json( $this->getRequirements() );
    }
    public function doAddRequirement()
    {
        $data = Input::only('name');
        $requirement = Requirement::create($data);

        return Response::json(array(
            'requirement' => $requirement->toArray(),
            'requirements' => $this->getRequirements()
        ));
    }
    private function getRequirements()
    {
        $requirements = Requirement::orderBy('name', 'asc')->get(['id', 'name'])->toArray();

        return array_merge([['id' => '0', 'name' => '- None -']], $requirements);
    }

    public function layouts()
    {
        return Response::json( $this->getLayouts() );
    }
    public function doAddLayout()
    {
        $data = Input::only('name');
        $layout = Layout::create($data);

        return Response::json(array(
            'layout' => $layout->toArray(),
            'layouts' => $this->getLayouts()
        ));
    }
    private function getLayouts()
    {
        $layouts = Layout::orderBy('name', 'asc')->get(['id', 'name'])->toArray();

        return array_merge([['id' => '0', 'name' => '- None -']], $layouts);
    }

    /* GET /adm/api/licences */
    public function licences(){
        return Response::json( $this->getAuthors() );
    }
    public function doAddLicence(){
        $data = Input::only('name', 'url');
        $data['url'] = '';
        $licence = Licence::create($data);


        return Response::json(array(
            'licence' => $licence->toArray(),
            'licences' => $this->getLicences()
        ));
    }
    private function getLicences(){
        $licences = Licence::orderBy('name', 'asc')->get(['id', 'name'])->toArray();

        return array_merge([['id' => '0', 'name' => '- None -']], $licences);
    }

    /* GET /adm/api/platforms */
    public function platforms(){
        return Response::json( $this->getAuthors() );
    }
    public function doAddPlatform(){
        $data = Input::only('name', 'url');
        $data['url'] = '';
        $platform = Platform::create($data);

        return Response::json(array(
            'platform' => $platform->toArray(),
            'platforms' => $this->getPlatforms()
        ));
    }
    private function getPlatforms(){
        $platforms= Platform::orderBy('name', 'asc')->get(['id', 'name'])->toArray();

        return array_merge([['id' => '0', 'name' => '- None -']], $platforms);
    }

}
