<?php namespace Gooeypress\Util;

use DB;

/**
 * Compute and update performance scores for all themes.
 */
class PerformanceRanker{
    public function rank()
    {
        $fields = ['http_requests', 'page_weight', 'code_quality', 'render_speed', 'code_placement', 'compression'];

        foreach($fields as $field){
            $this->rankField($field);
        }

        DB::update("UPDATE themes SET level_overall = (level_http_requests +
            level_page_weight + level_code_quality + level_render_speed + level_code_placement + level_compression) / 6
            WHERE state = 'ready' AND publication_status = 'published'");
    }

    public function rankField($field, $higher_is_better = true){
        $o_field = 'performance_'. $field;
        $l_field = 'level_'. $field;

        $scores = DB::table('themes')
            ->select($o_field)
            ->where('state', '=', 'ready')
            ->where('publication_status', '=', 'published')
            ->lists($o_field);

        sort($scores, SORT_NUMERIC);

        $tenth = count($scores) / 10;
        $percentiles = [];

        for($i = 0; $i < 10; $i++){
            $percentiles[$i] = $scores[ ($i+1) * $tenth -1 ];
        }
        $percentiles[9] = $scores[ count($scores) - 1 ];

        if( $higher_is_better ){
            $percentiles = array_reverse($percentiles);
            foreach($percentiles as $k => $bound){
                DB::update("UPDATE themes SET $l_field = ? WHERE $o_field <= ? AND state = 'ready' AND publication_status = 'published'",
                    [$k+1, $bound]);
            }
        }else{
            $percentiles = array_merge([0], $percentiles);
            foreach($percentiles as $k => $bound){
                DB::update("UPDATE themes SET $l_field = ? WHERE $o_field >= ? AND state = 'ready' AND publication_status = 'published'",
                    [$k+1, $bound]);
            }
        }

    }
}
