<?php

namespace App\Jobs;

use App\Models\School;
use GuzzleHttp\Client;
use Illuminate\Bus\Queueable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;

// class SyncSchoolListFromCore implements ShouldQueue
class SyncSchoolListFromCore
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
        $schools = $this->getSchoolList();

        if (count($schools) > 0) {
            foreach ($schools as $school) {
                School::updateOrCreate(
                    ['id' => $school->id],
                    [
                        'name' => $school->name,
                        'approved' => true,
                        'type' => config('quiz.target'),
                    ]
                );
            }
        }
    }

    public function getSchoolList()
    {
        try {
            $client = new \GuzzleHttp\Client([
                'verify' => !app()->isLocal()
            ]);

            $response = $client->request('GET', config('quiz.api_url') . "/v1/schools?type=" . config('quiz.target'));

            $code = $response->getStatusCode(); // 200

            if ($code === 200) {
                $rawData = json_decode($response->getBody()->getContents());

                return $rawData->data;
            }
        } catch (\Exception $exception) {
            \Log::error("Error occurred in synchronize school list. Error: {$exception->getMessage()}");

            abort(500);
        }
    }
}
