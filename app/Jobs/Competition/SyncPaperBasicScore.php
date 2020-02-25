<?php

namespace App\Jobs;

use Illuminate\Bus\Queueable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;

use App\Models\Paper;
use App\Models\BasicScore;

class SyncPaperBasicScore implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;
    
    public $paper;

    /**
     * Create a new job instance.
     *
     * @return void
     */
    public function __construct(Paper $paper)
    {
        $this->paper = $paper;
    }

    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle()
    {
        if ($this->isNewOrBetterScore()) {
            $this->sync();
        }
    }

    /**
     * Check whether this paper is new or better in terms of score or time.
     *
     * @return boolean
     */
    private function isNewOrBetterScore()
    {
        try {
            $basicScore = $this->paper->participant->bestScores()->where('season_id', $this->paper->season_id)->first();

            if (!$basicScore) {
                return true;
            }

            return $this->paper->score > $basicScore->score || ($this->paper->score == $basicScore->score && $this->paper->seconds_used < $basicScore->seconds_used);
        } catch (\Exception $exception) {
            \Log::error("Failed to check whether paper record is new or better. Error: {$exception->getMessage()}");
        }

        return false;
    }

    /**
     * Update / create score record.
     *
     * @return void
     */
    private function sync()
    {
        try {
            BasicScore::updateOrCreate(
                [
                    'participant_id' => $this->paper->participant_id,
                    'season_id' => $this->paper->season_id
                ],
                [
                    'paper_id' => $this->paper->id,
                    'score' => $this->paper->score,
                    'seconds_used' => $this->paper->seconds_used
                ]
            );
        } catch (\Exception $exception) {
            \Log::error("Failed to update / create basic score. Paper ID: {$this->paper->id}. Error: {$exception->getMessage()}");
        }
    }
}
