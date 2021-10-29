<?php

namespace App\Jobs\Participant;

use App\Models\Season;
use App\Models\WeeklyBasicScore;
use Carbon\Carbon;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\DB;

class UpdateWeeklyBasicRank implements ShouldQueue
{
    use Dispatchable;
    use InteractsWithQueue;
    use Queueable;
    use SerializesModels;

    public $season;
    public $force;

    /**
     * Create a new job instance.
     *
     * @return void
     */
    public function __construct(Season $season, $force = false)
    {
        $this->season = $season;
        $this->force = $force;
    }

    /**
     * Execute the job.
     *
     * @return void
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
                    // Only process past week and this week
                    if (false == $this->force && $week != $currentWeek && $week + 1 != $currentWeek) {
                        continue;
                    }
                    $finalised = ($year <= $currentYear && $week < $currentWeek) ? true : false;

                    $this->updateRank($year, $week, $finalised);
                }
            }
        }
    }

    private function updateRank($year, $week, $finalised)
    {
        try {
            // sorting weekly scores and rank it
            WeeklyBasicScore::inSeason($this->season->id)
                        ->inYear($year)
                        ->inWeek($week)
                        ->orderBy('score', 'desc')
                        ->orderBy('seconds_used', 'asc')
                        ->orderBy('started_at', 'asc')
                        ->each(function ($score, $index) use ($finalised) {
                            $score->rank = $index + 1;
                            $score->finalised = $finalised;
                            $score->save();
                        });
        } catch (\Exception $exception) {
            DB::rollback();

            \Log::debug("Failed to update weekly basic rank. Error: {$exception->getMessage()}");
        }
    }
}
