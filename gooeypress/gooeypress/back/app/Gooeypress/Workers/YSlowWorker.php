<?php namespace Gooeypress\Workers;

use Illuminate\Queue\Jobs\Job;
use Log, Theme, Config, DB, Event;

/**
 * Generate screenshot for themes using `phantomjs`
 */
class YSlowWorker
{
    /**
     * Take a screenshot
     * 
     * @param $data : ['theme_id' => $theme_id]
     */
    public function fire(Job $job, $data)
    {
        $theme_id = $data['theme_id'];

        $theme = Theme::findOrFail($theme_id);

        if($theme->default_layout_id <= 1){
            $job->release();
        }

        $layout = DB::select('SELECT * FROM layout_theme WHERE theme_id = ? AND layout_id = ?',
            [$theme->id, $theme->default_layout_id]);

        if(empty($layout)){
            throw new Exception("No layout [$theme->default_layout_id] found for theme [{$theme->id}]");
        }
        $layout = $layout[0];


        $cmd = join(' ', [ Config::get('workers.phantomjs_path'),
            Config::get('workers.yslow_script_path'),
            '--info grade,stats --format json',
            $layout->url ]);

        Log::info("Gathering YSlow stats for {$theme->title}[{$layout->url}]". PHP_EOL);
        Log::info("Cmd: $cmd". PHP_EOL);

        exec($cmd, $output, $return);


        $yslow = json_decode(join(PHP_EOL, $output));
        $yslow->comps = [];

        $theme->yslow = json_encode($yslow);
        $theme->performance_http_requests = $yslow->g->ynumreq->score;
        $theme->performance_page_weight = $yslow->w;
        $theme->performance_code_quality = $yslow->g->yemptysrc->score
            + $yslow->g->yexpressions->score
            //+ $yslow->g->yexternal->score
            + $yslow->g->ydns->score
            + $yslow->g->yminify->score
            + $yslow->g->ydupes->score
            + $yslow->g->yxhr->score
            + $yslow->g->yxhrmethod->score
            + $yslow->g->ymindom->score
            + $yslow->g->yno404->score
            + $yslow->g->ymincookie->score
            + $yslow->g->yimgnoscale->score
            + $yslow->g->yfavicon->score;
        $theme->performance_render_speed = $yslow->lt; // load time
        $theme->performance_code_placement = $yslow->g->ycsstop->score
            + $yslow->g->yjsbottom->score;
        $theme->performance_compression = $yslow->g->ycompress->score;

        $theme->save();

        Log::info("Done gathering YSlow stats for {$theme->title}[{$layout->url}]". PHP_EOL);
        Event::fire('workers.YSlowWasObtained', $theme);

        $job->delete();
    }
}
