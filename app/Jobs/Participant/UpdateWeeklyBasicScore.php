<?php

namespace App\Jobs\Participant;

use Carbon\Carbon;
use Illuminate\Bus\Queueable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use App\Models\WeeklyBasicScore;
use App\Models\Participant;
use App\Models\Season;
use Illuminate\Support\Facades\DB;

class UpdateWeeklyBasicScore implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    public $participant;
    public $seasonId;
    public $force;

    /**
     * Create a new job instance.
     */
    public function __construct(Participant $participant, Season $season, $force = false)
    {
        $this->participant = $participant;
        $this->season = $season;
        $this->force = $force;
    }

    /**
     * Execute the job.
     */
    public function handle()
    {
        $weeklyRankingRange = weekly_ranking_range();

        $seasonEndDate = Carbon::parse($this->season->end_at);

        // Get current year & week to generate current or past week's rankings
        // Not future week ranking
        if ($seasonEndDate < now()) {
            $currentYear = $seasonEndDate->year;
            $currentWeek = $seasonEndDate->weekOfYear;
        } else {
            $currentYear = Carbon::now()->year;
            $currentWeek = Carbon::now()->weekOfYear;
        }

        if (count($weeklyRankingRange)) {
            foreach ($weeklyRankingRange as $year => $weeks) {
                // Skip future years
                if (false == $this->force && $year > $currentYear) {
                    continue;
                }

                foreach ($weeks as $week => $range) {
                    // Skip current loop if force update is false and $key < current week of year
                    if (false == $this->force && $week != $currentWeek) {
                        continue;
                    }
                    
                    $this->update($week, $range['start_date'], $range['end_date']);
                }
            }
        }
    }

    private function update($week, $startDate, $endDate)
    {
        try {
            DB::beginTransaction();

            // Get highest score paper
            $paper = $this->participant->papers()
                        ->finished()
                        ->whereDate('started_at', '>=', $startDate . " 00:00:00")
                        ->whereDate('started_at', '<=', $endDate . " 23:59:59")
                        ->inSeason($this->season->id)
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
            // If no finished paper found, paper may be voided
            // delete any existing records of the season.
            } else {
                WeeklyBasicScore::where([
                    ['participant_id', $this->participant->id],
                    ['season_id', $this->season->id],
                    ['week_of_year', $week],
                ])->delete();
            }

            DB::commit();
        } catch (\Exception $exception) {
            DB::rollback();

            \Log::debug("Failed to update participant's weekly basic score. Error: {$exception->getMessage()}");
        }
    }
}
