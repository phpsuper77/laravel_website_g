<?php namespace Gooeypress\EventHandlers;

use Log, Theme, Event;

class ScreenshotWasTakenHandler{
    public function handle($theme_ids){
        Log::info($theme_ids);
        $theme_ids = explode(',', $theme_ids);
        foreach($theme_ids as $id){
            $theme = Theme::find($id);

            Log::info($theme->id . '-'. $theme->state);

            if($theme->state == 'completed' && $theme->screenshot != '' && $theme->yslow != ''){
                $theme->state = 'ready';
                $theme->save();
                Event::fire('theme.ThemeBecameReady', $theme);
            }
        }
    }
}
