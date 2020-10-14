<?php

namespace App\Jobs\Paper;

use Illuminate\Bus\Queueable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Support\Facades\Artisan;

class GeneratePaperForCurrentSeason implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    /**
     * Create a new job instance.
     *
     * @return void
     */
    public function __construct()
    {
        //
    }

    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle()
    {
        if ($season = season()) {
            $paperCount = $season->papers()->where('status', 'created')->count();

            if ($paperCount <= 1000) {
                Artisan::call('paper:generate', [
                    'number' => 1000,
                    'season' => $season->id
                ]);
            }
        }
    }
}
