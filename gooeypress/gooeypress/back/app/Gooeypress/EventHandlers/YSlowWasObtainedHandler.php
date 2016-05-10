<?php namespace Gooeypress\EventHandlers;

use Log, Event;

class YSlowWasObtainedHandler{
    public function handle($theme){
        Log::info($theme->id . '-'. $theme->state);
        if($theme->state == 'completed' && $theme->screenshot != '' && $theme->yslow != ''){
            $theme->state = 'ready';
            $theme->save();
            Event::fire('theme.ThemeBecameReady', $theme);
        }
    }
}
