<?php

namespace App\Jobs;

use App\Helpers\RankingManager;
use Illuminate\Bus\Queueable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;

// class PushWeeklyRankingData implements ShouldQueue
class PushWeeklyRankingData
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

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
            \Log::debug("Dispatch PushWeeklyRankingData halted. No ranking data");
            
            exit(0);
        }
    }

    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle()
    {
        $weeklyRankingRange = config('competition.weekly_ranking_range');

        if (!$weeklyRankingRange) {
            \Log::debug("competition.weekly_ranking_range is not configured.");

            exit(0);
        }

        $rankings = [];

        foreach ($weeklyRankingRange as $year => $weeks) {
            foreach ($weeks as $week => $range) {
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
                'rankings' => $rankings
            ]);
        }
    }

    private function getWeeklyRanking(string $week, bool $finalised = false)
    {
        $data = [
            'week' => $week,
            'rankings' => [],
        ];

        $rankings = $this->rankingData['personal_weekly'][$this->type][$week];

        if ($rankings) {
            foreach ($rankings as $index => $ranking) {
                $data['rankings'][] = [
                    'user_id' => $ranking->participant->user->id,
                    'rank' => $index + 1,
                    'score' => $ranking->score,
                    'seconds' => $ranking->seconds_used * 1000,
                    'recorded_at' => $ranking->started_at,
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
                'verify' => !app()->isLocal()
            ]);

            $response = $client->request('POST', config('quiz.api_url') . '/rankings/weekly', [
                'form_params' => $data
            ]);

            $code = $response->getStatusCode(); // 200

            return $code;
            \Log::debug("Pushed weekly ranking data to quizfunz. Status: {$code}");
        } catch (\Exception $exception) {
            \Log::error("Error occur in push ranking data. Error: {$exception->getMessage()}");

            return $exception->getMessage();
        }
    }
}
