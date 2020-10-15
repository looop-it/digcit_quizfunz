<?php

namespace App\Observers;

use App\Models\AdvList;
use App\Traits\HasCacheTrait;

class AdvertisementObserver
{
    use HasCacheTrait;

    private $cacheKey = 'advertisements';

    /**
     * Handle the advertisement "created" event.
     *
     * @param  \App\Models\AdvList
     * @return void
     */
    public function created(AdvList $adv)
    {
        //
    }

    /**
     * Handle the advertisement "updated" event.
     *
     * @param  \App\Models\AdvList
     * @return void
     */
    public function updated(AdvList $adv)
    {
        //
    }

    /**
     * Handle the advertisement "deleted" event.
     *
     * @param  \App\Models\AdvList
     * @return void
     */
    public function deleted(AdvList $adv)
    {
        //
    }
}
