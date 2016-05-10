<?php

use Gooeypress\Services\ThemeSearchFilter;

function filter_link(ThemeSearchFilter $filter, $section, $current)
{
    $url = "/themes?";

    $filters = [
        'price' => $filter->price,
        'layout' => $filter->layout,
        'responsive' => $filter->responsive,
        'genre' => $filter->genre,
        'style' => $filter->style,
        'features' => $filter->features,
        'performance' => $filter->performance,
    ];

    if(array_has($filters, $section)){
        $items = $filters[$section];
        $filters[$section] = in_array($current, $items)
            ? array_diff($items, [$current])
            : array_merge($items, [$current]);
    }

    $queries = array_map(function($key, $value){
        return $key . '=' . join(',', $value);
    }, array_keys($filters), array_values($filters));

    $order_by = Request::get('order_by');
    $order = Request::get('order');

    if($order_by) $queries[] = 'order_by='. $order_by;
    if($order) $queries[] = 'order='. $order;

    $query = join('&', $queries);

    return $url . $query . '&filter=true';
}

function browse_theme_order_by_link($property, $label)
{
    $uri = Request::url();

    $params = Request::all();

    $by = Request::get('order_by');
    if($property == $by){
        $order = Request::get('order') == 'asc' ? 'desc' : 'asc';
    }else{
        $order = Request::get('order');
    }

    $params['order_by'] = $property;
    $params['order'] = $order;

    $current = $by == $property ? 'browse_theme_sorter_btn_current' : '';
    $arrow = $order == 'asc' ? '<span class="icon-arrow-down"></span>' : '<span class="icon-arrow-up"></span>';
    $arrow = $current ? $arrow : '';

    $url = sprintf("%s?%s", $uri, http_build_query($params));

    $link = sprintf('<a href="%s" class="browse_theme_sorter_btn %s">%s %s</a>', $url, $current, $arrow, $label);

    return $link;
}