<?php

namespace App\Repositories;

use Carbon\Carbon;
use Illuminate\Support\Facades\Cache;

class WeeklyRankingRangeRepository
{
    private $cacheKey = 'weekly_ranking_range';

    public function getRange()
    {
        return Cache::remember($this->cacheKey, 60, function () {
            $range = [];

            $season = latestSeason();

            if (!$season) {
                throw new \Exception("No season found");
            }

            $startDate = Carbon::parse($season->start_at)->startOfWeek();
            $endDate = Carbon::parse($season->end_at)->endOfWeek();

            do {
                $year = $startDate->year;
                $week = $startDate->weekOfYear;

                // Workaround to get correct week.
                // Due to old version of carbon, cannot get isoWeekYear.
                if (isset($previousYear) && isset($previousWeek) && $week > $previousWeek) {
                    $year = $previousYear;
                }

                $range[$year][$week] = [
                    'start_date' => $startDate->startOfWeek()->format('Y-m-d'),
                    'end_date' => $startDate->endOfWeek()->format('Y-m-d'),
                ];

                $previousYear = $year;
                $previousWeek = $week;

                $startDate = $startDate->addWeeks(1);
            } while ($endDate->greaterThanOrEqualTo($startDate));

            return $range;
        });
    }

    public function clearCache()
    {
        Cache::forget($this->cacheKey);
    }
}
