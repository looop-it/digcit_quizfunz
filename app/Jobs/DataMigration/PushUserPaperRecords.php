<?php

namespace App\Jobs\DataMigration;

use App\Models\Participant;
use Illuminate\Bus\Queueable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;

class PushUserPaperRecords implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    protected $participant;

    /**
     * Create a new job instance.
     *
     * @return void
     */
    public function __construct(Participant $participant)
    {
        $this->participant = $participant;
    }

    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle()
    {
        $records = [];

        $this->participant->load(['user', 'papers' => function ($query) {
            return $query->finished();
        }]);

        foreach ($this->participant->papers as $paper) {
            $records[] = [
                'score' => $paper->score,
                'seconds' => $paper->seconds_used * 1000,
                'recorded_at' => $paper->finished_at,
                'reference' => "paper ID: {$paper->id}"
            ];
        }

        if (count($records) > 0) {
            foreach (array_chunk($records, 200, true) as $chunk) {
                $data = [
                    'migration' => true,
                    'quiz_id' => config('quiz.id'),
                    'user_id' => $this->participant->user->id,
                    'records' => $chunk
                ];

                $this->push($data);
            }
        }
    }

    private function push(array $data)
    {
        try {
            $client = new \GuzzleHttp\Client([
                'verify' => !app()->isLocal()
            ]);

            $response = $client->request('POST', config('quiz.api_url') . "/quiz_records", [
                'form_params' => $data
            ]);

            $code = $response->getStatusCode(); // 200

            return $code;

            \Log::debug("Pushed paper data to quizfunz. Status: {$code}");
        } catch (\Exception $exception) {
            \Log::error("Error occur in push paper data. Error: {$exception->getMessage()}");

            return $exception->getMessage();
        }
    }
}
