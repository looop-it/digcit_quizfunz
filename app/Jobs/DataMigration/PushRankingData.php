<?php

namespace App\Jobs\DataMigration;

use App\Helpers\RankingManager;
use Illuminate\Bus\Queueable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;

class PushRankingData implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    /**
     * Create a new job instance.
     *
     * @return void
     */
    public function __construct()
    {
        //
    }

    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle()
    {
        $rankingData = (new RankingManager())->setSeasonId(latestSeason()->id)
                                            ->getAllRanking();

        if ($rankingData) {
            $dataToPush = [
                'quiz_id' => config('quiz.id'),
                'rankings' => []
            ];

            // weekly ranking of recent 2 weeks
            if (array_key_exists('personal_weekly', $rankingData) && count($rankingData['personal_weekly']) > 0) {
                $weeklyRankings = array_reverse(
                    array_slice($rankingData['personal_weekly'], -2, 2, true)
                );

                foreach ($weeklyRankings as $week => $rankings) {
                    if (count($rankings) > 0) {
                        $data = [
                            'type' => 'weekly_ranking',
                            'name' => '每週最強知識王',
                            'date' => $this->getDateRangeByWeek($week),
                            'rankings' => []
                        ];
            
                        foreach (array_slice($rankings, 0, 10) as $index => $rank) {
                            $data['rankings'][] = [
                                'rank' => $index + 1,
                                'name' => $rank['participant_name'],
                                'school' => $rank['school_name'],
                                'data' => "{$rank['score']}分/{$rank['seconds_used']}秒",
                            ];
                        }
            
                        array_push($dataToPush['rankings'], $data);
                    }
                }
            }
            
            // school_participants
            if (array_key_exists('participate_count', $rankingData) && count($rankingData['participate_count']) > 0) {
                $data = [
                    'type' => 'school_participants',
                    'name' => '最具人氣學校',
                    'rankings' => []
                ];

                foreach ($rankingData['participate_count'] as $index => $rank) {
                    $data['rankings'][] = [
                        'rank' => $index + 1,
                        'school' => $rank['name'],
                        'data' => "{$rank['participants']}人"
                    ];
                }

                array_push($dataToPush['rankings'], $data);
            }

            // best_schools
            if (array_key_exists('accumulate_score', $rankingData) && count($rankingData['participate_count']) > 0) {
                $schoolRanking = array_slice($rankingData['accumulate_score'], 0, 10);

                if (count($schoolRanking) > 0) {
                    $data = [
                        'type' => 'best_schools',
                        'name' => '最傑出學校表現',
                        'rankings' => []
                    ];

                    foreach ($schoolRanking as $index => $rank) {
                        $data['rankings'][] = [
                            'rank' => $index + 1,
                            'school' => $rank['name'],
                            'data' => "{$rank['score']}分",
                        ];
                    }

                    array_push($dataToPush['rankings'], $data);
                }
            }

            $this->push($dataToPush);
        }
    }

    private function push(array $data)
    {
        try {
            $client = new \GuzzleHttp\Client([
                'verify' => !app()->isLocal()
            ]);

            $response = $client->request('POST', config('quiz.api_url') . '/v1/rankings', [
                'form_params' => $data
            ]);

            $code = $response->getStatusCode(); // 200

            return $code;
            \Log::debug("Pushed ranking data to quizfunz. Status: {$code}");
        } catch (\Exception $exception) {
            \Log::error("Error occur in push ranking data. Error: {$exception->getMessage()}");

            return $exception->getMessage();
        }
    }

    /**
     * Get date range by week
     *
     * @param string $week
     * @return string|null
     */
    private function getDateRangeByWeek(string $week) : ?string
    {
        // Get Date range
        try {
            $yearWeek = explode('_', $week);
            $date = now()->setISODate($yearWeek[0], $yearWeek[1]);
        
            return $date->startOfWeek()->format('d/m/Y') . ' - ' . $date->endOfWeek()->format('d/m/Y');
        } catch (\Exception $exception) {
            \Log::error("Failed to get date range by week. Error: {$exception->getMessage()}");
        }

        return null;
    }
}
