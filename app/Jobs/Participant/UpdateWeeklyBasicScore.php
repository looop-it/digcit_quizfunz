<?php

namespace App\Jobs;

use Carbon\Carbon;
use Illuminate\Bus\Queueable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use App\Models\WeeklyBasicScore;
use App\Models\Participant;

class UpdateWeeklyBasicScore implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    public $participant;
    public $seasonId;
    public $force;

    /**
     * Create a new job instance.
     */
    public function __construct(Participant $participant, int $seasonId, $force = false)
    {
        $this->participant = $participant;
        $this->seasonId = $seasonId;
        $this->force = $force;
    }

    /**
     * Execute the job.
     */
    public function handle()
    {
        $weekly_ranking_range = config('competition.weekly_ranking_range');
        $currentYear = Carbon::now()->year;
        $currentWeek = Carbon::now()->weekOfYear;

        if (count($weekly_ranking_range)) {
            foreach ($weekly_ranking_range as $year => $weeks) {
                if ($year <= $currentYear) {
                    foreach ($weeks as $week => $range) {
                        if (false == $this->force && $week < $currentWeek) {
                            // Skip current loop if force update is false and $key < current week of year
                            continue;
                        }

                        // Get highest score paper
                        $paper = $this->participant->papers()
                                        ->finished()
                                        ->whereDate('started_at', '>=', $range['start_date'])
                                        ->whereDate('started_at', '<=', $range['end_date'])
                                        ->inSeason($this->seasonId)
                                        ->orderBy('score', 'desc')
                                        ->orderBy('seconds_used', 'asc')
                                        ->orderBy('started_at', 'asc')
                                        ->first();
    
                        if ($paper) {
                            WeeklyBasicScore::updateOrCreate(
                                [
                                'participant_id' => $paper->participant_id,
                                'season_id' => $paper->season_id,
                                'week_of_year' => $week,
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
                            WeeklyBasicScore::where([
                                ['participant_id', $this->participant->id],
                                ['season_id', $this->seasonId],
                                ['week_of_year', $week],
                            ])->delete();
                        }
                    }
                }
            }
        }
    }
}
