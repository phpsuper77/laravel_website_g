<?php

use Gooeypress\Services\ThemeSearchFilter;
use Gooeypress\Services\ThemeSearchService;
use Laracasts\TestDummy\DbTestCase;
use Laracasts\TestDummy\Factory;

class ThemeSearchTest extends DbTestCase {

    /**
     * @var ThemeSearchService
     */
    protected $searchService;

    public function setUp()
    {
        parent::setUp();

        $this->searchService = new ThemeSearchService();
    }

    /** @test */
    public function it_returns_themes_matching_given_filters()
    {
        Factory::times(10)->create('Theme', ['price_type' => 'fixed', 'price' => 25]);
        Factory::times(15)->create('Theme', ['price_type' => 'fixed', 'price' => 35]);

        $filter1 = new ThemeSearchFilter('0', '', '', '', '', '', '');
        $filter2 = new ThemeSearchFilter('1', '', '', '', '', '', '');
        $filter3 = new ThemeSearchFilter('0,1', '', '', '', '', '', '');

        $themeSet1 = $this->searchService->filter($filter1);
        $themeSet2 = $this->searchService->filter($filter2);
        $themeSet3 = $this->searchService->filter($filter3);


        $this->assertCount(10, $themeSet1);
        $this->assertCount(15, $themeSet2);
        $this->assertCount(25, $themeSet3);
    }

    /** @test */
    public function it_filters_themes_given_layout_filters()
    {
        $layouts = Factory::times(2)->create('Layout');


        $themes1 = Factory::times(2)->create('Theme', [ 'default_layout_id' => $layouts[0]->id, 'price_type' => 'free' ]);
        $themes2 = Factory::times(4)->create('Theme', [ 'default_layout_id' => $layouts[1]->id, 'price_type' => 'fixed', 'price' => 25 ]);

        foreach ($themes1 as $theme)
        {
            DB::table('layout_theme')->insert(['theme_id' => $theme->id, 'layout_id' => $layouts[0]->id]);
        }
        foreach ($themes2 as $theme)
        {
            DB::table('layout_theme')->insert(['theme_id' => $theme->id, 'layout_id' => $layouts[1]->id]);
        }

        $filter1 = new ThemeSearchFilter('', $layouts[0]->id, '', '', '', '', '');
        $filter2 = new ThemeSearchFilter('', $layouts[1]->id, '', '', '', '', '');
        $filter3 = new ThemeSearchFilter('5', $layouts[0]->id . ','. $layouts[1]->id, '', '', '', '', '');
        $filter4 = new ThemeSearchFilter('0', $layouts[0]->id . ','. $layouts[1]->id, '', '', '', '', '');
        $filter5 = new ThemeSearchFilter('5', $layouts[1]->id, '', '', '', '', '');

        $themeSet1 = $this->searchService->filter($filter1);
        $themeSet2 = $this->searchService->filter($filter2);
        $themeSet3 = $this->searchService->filter($filter3);
        $themeSet4 = $this->searchService->filter($filter4);
        $themeSet5 = $this->searchService->filter($filter5);

        $this->assertCount(2, $themeSet1);
        $this->assertCount(4, $themeSet2);
        $this->assertCount(2, $themeSet3);
        $this->assertCount(4, $themeSet4);
        $this->assertCount(0, $themeSet5);
    }

}