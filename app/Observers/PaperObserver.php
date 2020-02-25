<?php

namespace App\Observers;

use App\Models\Paper;
use App\Jobs\StoreAnswerFromCache;
use App\Jobs\UpdateBasicScore;
use App\Jobs\SyncPaperBasicScore;
use App\Jobs\ArchivePaperAnswers;
use Illuminate\Support\Facades\Cache;
use App\Facades\PaperManager;

class PaperObserver
{
    /**
     * Handle the Paper "created" event.
     *
     * @param  \App\Models\Paper  $paper
     * @return void
     */
    public function created(Paper $paper)
    {
        //
    }

    /**
     * Handle the Paper "updated" event.
     *
     * @param  \App\Models\Paper  $paper
     * @return void
     */
    public function updated(Paper $paper)
    {
        switch ($paper->status) {
            case 'reviewing':
                StoreAnswerFromCache::dispatch($paper)->delay(now()->addSeconds(2));
                break;
            case 'finished':
                SyncPaperBasicScore::dispatch($paper)->delay(now()->addSeconds(2));
                ArchivePaperAnswers::dispatch($paper)->delay(now()->addSeconds(2));

                $this->clearCache($paper);
                break;
            case 'voided':
                UpdateBasicScore::dispatch($paper->participant, $paper->season_id)->delay(now()->addSeconds(2));
                break;
        }
    }

    /**
     * Handle the Paper "deleted" event.
     *
     * @param  \App\Models\Paper  $paper
     * @return void
     */
    public function deleted(Paper $paper)
    {
        //
    }

    /**
     * Clear paper related caches.
     *
     * @param  \App\Models\Paper  $paper
     * @return void
     */
    private function clearCache(Paper $paper)
    {
        // Clear user paper id cache
        $paper->user->clearCurrentPaperId();

        // Clear user participate session
        Cache::forget("user:{$paper->user->id}:participate");

        // Clear paper caches
        $paperManager = PaperManager::setPaperId($paper->id);
        $paperManager->cache->clearPaper();
    }
}
