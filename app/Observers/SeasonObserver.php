<?php

namespace App\Observers;

use App\Models\Season;
use Illuminate\Support\Facades\Cache;

class SeasonObserver
{
    /**
     * Handle the Season "created" event.
     *
     * @param  \App\Models\Season  $season
     * @return void
     */
    public function created(Season $season)
    {
        if ($season->status == 'open') {
            $this->removeCache();
        }
    }

    /**
     * Handle the Season "updated" event.
     *
     * @param  \App\Models\Season  $season
     * @return void
     */
    public function updated(Season $season)
    {
        $this->removeCache();
    }

    /**
     * Handle the Season "deleted" event.
     *
     * @param  \App\Models\Season  $season
     * @return void
     */
    public function deleted(Season $season)
    {
        $this->removeCache();
    }

    /**
     * Remove season cache.
     *
     * @return void
     */
    private function removeCache()
    {
        return Cache::forget('current_season');
    }
}
