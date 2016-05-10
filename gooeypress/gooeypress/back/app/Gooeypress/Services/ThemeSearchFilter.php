<?php


namespace Gooeypress\Services;


class ThemeSearchFilter {

    public $price;
    public $layout;
    public $responsive;
    public $genre;
    public $style;
    public $features;
    public $performance;

    private $filters = ['price', 'layout', 'responsive', 'genre',
        'style', 'features', 'performance'];

    public function __construct($price, $layout, $responsive, $genre, $style, $features, $performance)
    {
        $this->price = $this->toArray($price);
        $this->layout = $this->toArray($layout);
        $this->responsive = $this->toArray($responsive);
        $this->genre = $this->toArray($genre);
        $this->style = $this->toArray($style);
        $this->features = $this->toArray($features);
        $this->performance = $this->toArray($performance);
    }

    public static function create(array $filters)
    {
        $filters = array_merge([
            'price' => '', 'layout' => '', 'responsive' => '', 'genre' => '',
            'style' => '', 'features' => '', 'performance' => ''

        ], $filters);

        return new static(
            $filters['price'],
            $filters['layout'],
            $filters['responsive'],
            $filters['genre'],
            $filters['style'],
            $filters['features'],
            $filters['performance']
        );
    }

    /**
     * @return array
     */
    public static function getPrices()
    {
        return self::$prices;
    }

    public function filterNumber($property = '')
    {
        if(in_array($property, $this->filters)){
            return count($this->{$property});
        }

        $number = 0;
        foreach ($this->filters as $filter)
        {
            $number += count($this->{$filter});
        }

        return $number;
    }

    /**
     * Get the main filter condition on the `themes` table
     *
     * @return string
     */
    public function getFilterCondition()
    {
        $where = [];

        $price_condition = $this->getPriceCondition();

        if ($price_condition != '')
            $where[] = "( $price_condition )";

        foreach ([
                     'responsive'  => $this->responsive,
                     'genre_id'    => $this->genre,
                     'style_id'    => $this->style,
                     'features'    => $this->features,
                     'performance' => $this->performance
                 ] as $column => $filters)
        {
            $condition = $this->getColumnCondition($column, $filters);

            if ($condition != '')
            {
                $where[] = $condition;
            }
        }

        return join(' AND ', $where);
    }

    /**
     * Get the layout filter condition on the `layout_theme` table
     *
     * @return string
     */
    public function getLayoutFilterCondition()
    {
        $condition = $this->getColumnCondition('layout_id', $this->layout);

        return $condition;
    }

    /**
     * Convert a comma-separated string filter attribute to array
     *
     * @param $attribute
     * @return array
     */
    private function toArray($attribute)
    {
        $values = explode(',', $attribute);

        if (count($values) == 1 && $values[0] === '')
        {
            return [];
        }

        $r = [];
        foreach ($values as $value)
        {
            $r[] = intval($value);
        }

        return array_unique($r);
    }

    /**
     * Get a sub where clause of $column in ($ins)
     *
     * @param $column
     * @param $ins
     * @return string
     */
    private function getColumnCondition($column, $ins)
    {
        if (count($ins) == 0)
        {
            return '';
        }

        return sprintf("%s IN (%s)", $column, join(',', $ins));
    }

    /**
     * Get the condition based on price filters
     *
     * @return string
     */
    private function getPriceCondition()
    {
        if (count($this->price) == 0)
        {
            return '';
        }

        $where = [];
        foreach ($this->price as $price)
        {
            if(array_key_exists($price, self::$prices)){
                $where[] = sprintf("(%s)", $this->parseCondition(self::$prices[$price]['filter']));
            }
        }

        return join(' OR ', $where);
    }

    /**
     * Parse a where condition in the form of `column:operator:value`
     *
     * @param $condition
     * @return string
     */
    private function parseCondition($condition)
    {
        $filters = preg_split('/,\s?/', $condition);

        $where = [];
        foreach ($filters as $filter)
        {
            list($column, $op, $value) = explode(':', $filter);
            $where[] = "$column $op '$value'";
        }

        return join(' AND ', $where);
    }

    protected static $prices = [
        ['label' => '$1-$25', 'filter' => 'price_type:=:fixed, price:>=:1, price:<=:25'],
        ['label' => '$26-$35', 'filter' => 'price_type:=:fixed, price:>=:26, price:<=:35'],
        ['label' => '$35-$50', 'filter' => 'price_type:=:fixed, price:>=:36, price:<=:25'],
        ['label' => '$51-$75', 'filter' => 'price_type:=:fixed, price:>=:51, price:<=:75'],
        ['label' => '$75 & Above', 'filter' => 'price_type:=:fixed, price:>=:75'],
        ['label' => 'Free', 'filter' => 'price_type:=:free'],
        ['label' => 'Subscription', 'filter' => 'price_type:=:subscription'],
    ];

}