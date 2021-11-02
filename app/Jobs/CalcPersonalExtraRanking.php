<?php

namespace App\Jobs;

use App\Models\PersonalExtraRanking;
use App\Models\WeeklyBasicScore;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\DB;

class CalcPersonalExtraRanking implements ShouldQueue
{
    use Dispatchable;
    use InteractsWithQueue;
    use Queueable;
    use SerializesModels;

    // define the weeks needed to filter the winner
    private const REQUIRED_WEEKS = 3;

    /**
     * Create a new job instance.
     *
     * @return void
     */
    public function __construct()
    {
    }

    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle()
    {
        // select participants who win the top 10 rank more than 3 times
        $winners = WeeklyBasicScore::select(DB::raw('count(*) as p_count, participant_id'))
                                            ->inSeason(latestSeason()->id)
                                            ->where('rank', '>', 0)
                                            ->where('rank', '<=', 10)
                                            ->groupBy('participant_id')
                                            ->having('p_count', '>', 1)
                                            ->get();

        if ($winners) {
            foreach ($winners as $key => $winner) {
                \Log::debug("start to procsssExtraRanking for participant: {$winner->participant_id} ");
                $this->procsssExtraRanking($winner->participant_id);
            }
        }
    }

    private function procsssExtraRanking($participant_id)
    {
        $records = WeeklyBasicScore::inSeason(latestSeason()->id)
                            ->where('rank', '>', 0)
                            ->where('rank', '<=', 10)
                            ->where('participant_id', $participant_id)
                            ->orderBy('started_at', 'asc')
                            ->get();
        if (count($records) >= self::REQUIRED_WEEKS) {
            // slice REQUIRED_WEEKS-1 weeks take the REQUIRED_WEEKS week
            $added_week = $records->slice(self::REQUIRED_WEEKS - 1)->first();
            $sum_scores = $added_week->participant->papers()->inSeason(latestSeason()->id)->finished()->sum('score');
            $sum_seconds = $added_week->participant->papers()->inSeason(latestSeason()->id)->finished()->sum('seconds_used');
            PersonalExtraRanking::updateOrCreate(
                ['participant_id' => $added_week->participant_id],
                [
                    'added_year' => $added_week->year,
                    'added_week' => $added_week->week_of_year,
                    'season_id' => $added_week->season_id,
                    'sum_scores' => $sum_scores,
                    'sum_seconds' => $sum_seconds,
                    ]
                );
        } else {
            \Log::debug("Failed to procsssExtraRanking for participant: {$participant_id}  due to no enough top 10 records.");
        }
    }
}
