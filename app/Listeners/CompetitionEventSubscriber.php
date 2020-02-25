<?php

namespace App\Listeners;

use App\Events\CompetitionStarted;
use App\Events\CompetitionFinished;
use App\Jobs\FinishPaper;

class CompetitionEventSubscriber
{
    /**
     * Register the listeners for the subscriber.
     *
     * @param  Illuminate\Events\Dispatcher $events
     */
    public function subscribe($events)
    {
        $events->listen(
            CompetitionStarted::class,
            'App\Listeners\CompetitionEventSubscriber@onCompetitionStarted'
        );

        $events->listen(
            CompetitionFinished::class,
            'App\Listeners\CompetitionEventSubscriber@onCompetitionFinished'
        );
    }

    /**
     * Handle user login events.
     */
    public function onCompetitionStarted($event)
    {
        //
    }

    /**
     * Handle user logout events.
     */
    public function onCompetitionFinished($event)
    {
        dispatch(new FinishPaper($event->paper, $event->finishedAt));
    }
}
