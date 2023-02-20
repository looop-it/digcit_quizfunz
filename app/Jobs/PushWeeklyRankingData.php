<?php

namespace App\Jobs;

use App\Helpers\RankingManager;
use Carbon\Carbon;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;

// class PushWeeklyRankingData implements ShouldQueue
class PushWeeklyRankingData
{
    use Dispatchable;
    use InteractsWithQueue;
    use Queueable;
    use SerializesModels;

    private $type;
    private $rankingData;

    /**
     * Create a new job instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->type = config('quiz.target');
        $this->rankingData = (new RankingManager())->setSeasonId(latestSeason()->id)->getAllRanking();

        if (!$this->rankingData) {
            \Log::debug('Dispatch PushWeeklyRankingData halted. No ranking data');

            return false;
        }
    }

    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle()
    {
        // $weeklyRankingRange = config('competition.weekly_ranking_range');
        $weeklyRankingRange = weekly_ranking_range();

        if (!$weeklyRankingRange) {
            \Log::debug('competition.weekly_ranking_range is not configured.');

            return false;
        }

        $rankings = [];

        $seasonEndDate = Carbon::parse(latestSeason()->end_at);
        if ($seasonEndDate < now()) {
            $currentYear = $seasonEndDate->year;
            $currentWeek = $seasonEndDate->weekOfYear;
        } else {
            $currentYear = Carbon::now()->year;
            $currentWeek = Carbon::now()->weekOfYear;
        }

        foreach ($weeklyRankingRange as $year => $weeks) {
            if ($year > $currentYear) {
                continue;
            }
            foreach ($weeks as $week => $range) {
                if ($week > $currentWeek) {
                    continue;
                }
                $date = now();
                $date->setISODate($year, $week);
                $finalised = $date->endOfWeek()->lte(now());

                $data = $this->getWeeklyRanking("{$year}_{$week}", $finalised);

                if (count($data['rankings']) > 0) {
                    $rankings[] = $data;
                }
            }
        }

        if (count($rankings) > 0) {
            $this->push([
                'quiz_id' => config('quiz.id'),
                'rankings' => $rankings,
            ]);
        }
    }

    // "personal_weekly" => [
    //     "2021_42" => [
    //       [
    //         "participant_id" => 8,
    //         "participant_name" => "温啟月",
    //         "grade" => "中三",
    //         "class" => "3C",
    //         "school_name" => "屯門天主教中學",
    //         "score" => 100,
    //         "seconds_used" => 36,
    //         "started_at" => "2021-10-21 18:54:35",
    //       ],

    private function getWeeklyRanking(string $week, bool $finalised = false)
    {
        $data = [
            'week' => $week,
            'rankings' => [],
        ];

        // $rankings = $this->rankingData['personal_weekly'][$this->type][$week];
        $rankings = $this->rankingData['personal_weekly'][$week];

        if ($rankings) {
            foreach ($rankings as $index => $ranking) {
                $data['rankings'][] = [
                    'user_id' => $ranking['uuid'],
                    'rank' => $index + 1,
                    'score' => $ranking['score'],
                    'seconds' => $ranking['seconds_used'] * 1000,
                    'recorded_at' => $ranking['started_at'],
                    'finalised' => $finalised,
                ];
            }
        }

        return $data;
    }

    private function push(array $data)
    {
        try {
            $client = new \GuzzleHttp\Client([
                'verify' => !app()->isLocal(),
            ]);

            $response = $client->request('POST', config('quiz.api_url').'/v1/rankings/weekly', [
                'form_params' => $data,
            ]);

            $code = $response->getStatusCode(); // 200
            \Log::debug("Pushed weekly ranking data to quizfunz. Status: {$code}");

            return $code;
        } catch (\Exception $exception) {
            \Log::error("Error occur in push ranking data. Error: {$exception->getMessage()}");

            return $exception->getMessage();
        }
    }
}
