<?php namespace Gooeypress\Services;

use DB;
use Theme;

class ThemeSearchService {

    public function search($keyword)
    {

    }

    public function filter(ThemeSearchFilter $filter)
    {

        $where = '1';
        $where .= $this->getThemeIDsByLayout($filter);
        $where .= $this->getThemesByMainFilters($filter);

        $themes = Theme::live()->whereRaw($where);

        return $themes;
    }

    /**
     * @param ThemeSearchFilter $filter
     * @return string
     */
    protected function getThemeIDsByLayout(ThemeSearchFilter $filter)
    {
        $where = '';
        $layout_condition = $filter->getLayoutFilterCondition();
        if ($layout_condition != '')
        {
            $theme_ids = DB::table('layout_theme')->whereRaw($layout_condition)->lists('theme_id');

            if (count($theme_ids) != 0)
            {
                $where = sprintf(' AND id IN (%s)', join(',', $theme_ids));
            }else{
                $where = ' AND 0 ';
            }
        }

        return $where;
    }

    /**
     * @param ThemeSearchFilter $filter
     * @return string
     */
    protected function getThemesByMainFilters(ThemeSearchFilter $filter)
    {
        $main_condition = $filter->getFilterCondition();

        if ($main_condition != '')
        {
            $where = ' AND ' . $main_condition;

            return $where;
        }

        return '';
    }
}