<?php

namespace App\Jobs\Participant;

use App\Admin\Models\Participant;
use App\Models\PersonalExtraRanking;
use App\Models\Season;
use App\Models\WeeklyBasicScore;
use Carbon\Carbon;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\DB;
use Log;

class UpdateWeeklyBasicRank implements ShouldQueue
{
    use Dispatchable;
    use InteractsWithQueue;
    use Queueable;
    use SerializesModels;

    private const REQUIRED_WEEKS = 3; // PersonalExtraRanking required win times (weekly top-10)
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
                Log::debug("---- start to process year {$year} ----");

                // Skip future years
                if ($year > $currentYear) {
                    Log::debug("year {$year} skip");
                    continue;
                }

                foreach ($weeks as $week => $range) {
                    Log::debug("---- start to process week {$week} ----");
                    // Skip future weeks
                    // Only process past week and this week by default
                    if ((false == $this->force && $week != $currentWeek && $week + 1 != $currentWeek) || ($week > $currentWeek)) {
                        Log::debug("week {$week} skip");
                        continue;
                    }
                    $finalised = ($year <= $currentYear && $week < $currentWeek) ? true : false;

                    // $pastWeek = $this->getPastWeek($year, $week, $range);

                    $this->updateRawRank($year, $week, $finalised);
                    $this->updatePersonalExtraRank($year, $week, $finalised);
                    $this->updateRank($year, $week, $finalised);
                }
            }
        }
    }

    private function getPastWeek($year, $week, $range)
    {
        if ($week > 1) {
            return [
                'year' => $year,
                'week' => $week - 1,
            ];
        } else {
            return [
                'year' => $year - 1,
                'week' => carbon::parse($range['start_date'])->subWeek()->weekOfYear,
            ];
        }
    }

    private function updateRawRank($year, $week, $finalised)
    {
        try {
            // sorting weekly scores and rank it
            $records = WeeklyBasicScore::inSeason($this->season->id)
                        ->inYear($year)
                        ->inWeek($week)
                        ->orderBy('score', 'desc')
                        ->orderBy('seconds_used', 'asc')
                        ->orderBy('started_at', 'asc')
                        ->get();
            // Update raw rank
            $rank_raw_update = $records->each(function ($score, $index) use ($finalised) {
                $score->rank_raw = $index + 1;
                $score->finalised = $finalised;
                $score->save();
            });
        } catch (\Exception $exception) {
            DB::rollback();

            Log::debug("Failed to update weekly basic  rank_raw. Error: {$exception->getMessage()}");
        }
    }

    /**
     * Update rank without extra ranking list.
     *
     * @param [type] $year
     * @param [type] $week
     *
     * @return void
     */
    private function updateRank($year, $week)
    {
        try {
            // Get this week's raw rank sotring
            $records = WeeklyBasicScore::inSeason($this->season->id)
                                            ->inYear($year)
                                            ->inWeek($week)
                                            ->orderBy('score', 'desc')
                                            ->orderBy('seconds_used', 'asc')
                                            ->orderBy('started_at', 'asc')
                                            // ->take(100)
                                            ->get();

            // Get participants list who reach the top-10 times limit before this week
            $rejects = PersonalExtraRanking::select(['participant_id'])
                                                ->Where(function ($query) use ($year, $week) {
                                                    $query->where(function ($query) use ($year, $week) {
                                                        $query->where('added_week', '<=', $week)->where('added_year', $year);
                                                    })->orwhere('added_year', '<', $year);
                                                })
                                                ->get()
                                                ->pluck('participant_id');
            Log::debug("Week: {$week}, rejects list {$rejects}");

            // Update rank without extra ranking list before this week
            // And add the new reached participant to extra ranking
            $records->reject(function ($record, $index) use ($rejects) {
                // Reject panticipants who reach the top-10 times limit before this week
                return $rejects->contains($record->participant_id);
            })->values()->each(function ($rank, $index) {
                $rank->rank = $index + 1;
                $rank->save();
            });
        } catch (\Exception $exception) {
            DB::rollback();

            Log::debug("Failed to updateRank. Error: {$exception->getMessage()}");
        }
    }

    private function updatePersonalExtraRank($year, $week, $finalised)
    {
        try {
            // get reach REQUIRED_WEEKS participants count by this week before
            $records = WeeklyBasicScore::select(DB::raw('count(*) as p_count, participant_id'))
                                            ->where('rank', '>', 0)
                                            ->where('rank', '<=', 10)
                                            ->inSeason($this->season->id)
                                            ->Where(function ($query) use ($year, $week) {
                                                $query->where(function ($query) use ($year, $week) {
                                                    $query->where('week_of_year', '<', $week)->where('year', $year);
                                                })->orwhere('year', '<', $year);
                                            })
                                            ->where('finalised', 1)
                                            ->groupBy('participant_id')
                                            ->having('p_count', '>=', self::REQUIRED_WEEKS)
                                            ->get();
            if ($records) {
                foreach ($records as $index => $record) {
                    $sum_scores = $record->participant->papers()->inSeason(latestSeason()->id)->finished()->sum('score');
                    $sum_seconds = $record->participant->papers()->inSeason(latestSeason()->id)->finished()->sum('seconds_used');
                    PersonalExtraRanking::firstOrCreate(
                        ['participant_id' => $record->participant_id],
                        [
                            'added_year' => $year,
                            'added_week' => $week,
                            'season_id' => $this->season->id,
                            'sum_scores' => $sum_scores,
                            'sum_seconds' => $sum_seconds,
                            ]
                        );
                    Log::debug("Found participant reach the requirement, Week: {$week}, Participant_id: {$record->participant_id}");
                }
            } else {
                Log::debug("No participants reach the requirement, Week: {$week}");
            }
        } catch (\Exception $exception) {
            DB::rollback();

            Log::debug("Failed to updatePersonalExtraRank. Error: {$exception->getMessage()}");
        }
    }
}
