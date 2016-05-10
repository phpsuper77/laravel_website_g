<?php

use Gooeypress\Services\ThemeSearchFilter;
use Laracasts\TestDummy\DbTestCase;

class ThemeSearchFilterTest extends DbTestCase {

    /**
     * @var \Gooeypress\Services\ThemeSearchFilter
     */
    protected $filter;

    public function setUp()
    {
        parent::setUp();

        $price = '0,1';
        $layout = '1';
        $responsive = '1,2';
        $genre = '2,3,4';
        $style = '';
        $feature = '2';
        $performance = '';

        $this->filter = new ThemeSearchFilter($price, $layout, $responsive, $genre, $style, $feature, $performance);
    }

    /** @test */
    public function it_parses_filter_conditions_to_arrays()
    {
        $this->assertEquals(['2', '3', '4'], $this->filter->genre);
        $this->assertEquals(['1'], $this->filter->layout);
        $this->assertEquals([], $this->filter->performance);
    }

    /** @test */
    public function it_returns_filtering_conditions_for_database_query()
    {
        $filter = new ThemeSearchFilter('0', '', '', '', '', '', '');
        $conditions = $filter->getFilterCondition();
        $this->assertEquals("( (price_type = 'fixed' AND price >= '1' AND price <= '25') )", $conditions);

        $filter = new ThemeSearchFilter('0,4,5', '', '', '', '', '', '');
        $conditions = $filter->getFilterCondition();
        $this->assertEquals("( (price_type = 'fixed' AND price >= '1' AND price <= '25') OR (price_type = 'fixed' AND price >= '75') OR (price_type = 'free') )", $conditions);

        $filter = new ThemeSearchFilter('0', '', '', '', '3', '', '');
        $conditions = $filter->getFilterCondition();
        $this->assertEquals("( (price_type = 'fixed' AND price >= '1' AND price <= '25') ) AND style_id IN (3)", $conditions);
    }

    /** @test */
    public function it_handles_invalid_parameters()
    {
        $filter = new ThemeSearchFilter('a,b', '', '', '', '', '', '');
        $conditions = $filter->getFilterCondition();
        $this->assertEquals("( (price_type = 'fixed' AND price >= '1' AND price <= '25') )", $conditions);

        $filter = new ThemeSearchFilter('9', '', '', '', '', '', '');
        $conditions = $filter->getFilterCondition();
        $this->assertEquals("", $conditions);
    }

    /** @test */
    public function it_returns_layout_filters_properly()
    {
        $filter = new ThemeSearchFilter('', '6,9,6', '', '', '', '', '');
        $conditions = $filter->getLayoutFilterCondition();
        $this->assertEquals('layout_id IN (6,9)', $conditions);
    }

}