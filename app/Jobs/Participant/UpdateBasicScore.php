<?php

namespace App\Jobs;

use Illuminate\Bus\Queueable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use App\Models\BasicScore;
use App\Models\Participant;

class UpdateBasicScore implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    public $participant;
    public $seasonId;

    /**
     * Create a new job instance.
     */
    public function __construct(Participant $participant, int $seasonId)
    {
        $this->participant = $participant;
        $this->seasonId = $seasonId;
    }

    /**
     * Execute the job.
     */
    public function handle()
    {
        // Get highest score paper
        $paper = $this->participant->papers()->finished()
                            ->inSeason($this->seasonId)
                            ->orderBy('score', 'desc')
                            ->orderBy('seconds_used', 'asc')
                            ->first();

        if ($paper) {
            BasicScore::updateOrCreate(
                [
                    'participant_id' => $paper->participant_id,
                    'season_id' => $paper->season_id,
                ],
                [
                    'paper_id' => $paper->id,
                    'score' => $paper->score,
                    'seconds_used' => $paper->seconds_used,
                    'started_at' => $paper->started_at,
                ]
            );
        // If no finished paper found, may be due to paper voided
        // delete any existing records of the season.
        } else {
            BasicScore::where([
                ['participant_id', $this->participant->id],
                ['season_id', $this->seasonId],
            ])->delete();
        }
    }
}
