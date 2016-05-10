<?php namespace Gooeypress\EventHandlers;

use Gooeypress\Util\PerformanceRanker;
use Log;

class ThemeBecameReadyHandler
{
    private $ranker;

    public function __construct(PerformanceRanker $ranker){
        $this->ranker = $ranker;
    }
    public function handle($theme)
    {
        Log::info('Reranking themes'. PHP_EOL);
        $this->ranker->rank();
    }
}
