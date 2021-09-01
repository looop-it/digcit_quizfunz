<?php

namespace App\Jobs\DataMigration;

use App\Models\Participant;
use Illuminate\Bus\Queueable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;

class MigratePaperRecords implements ShouldQueue
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
        Participant::whereHas('papers', function ($query) {
            return $query->finished();
        })->chunk(200, function ($participants) {
            foreach ($participants as $participant) {
                dispatch(new PushUserPaperRecords($participant));
            }
        });
    }
}
