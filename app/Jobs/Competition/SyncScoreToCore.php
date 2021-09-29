<?php

namespace App\Jobs\Competition;

use App\Models\Paper;
use Facades\App\Utilities\JWTEncrypt;
use Illuminate\Bus\Queueable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use GuzzleHttp\Client as HttpClient;

class SyncScoreToCore implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    public $paper;

    /**
     * Create a new job instance.
     *
     * @return void
     */
    public function __construct(Paper $paper)
    {
        $this->paper = $paper;
    }

    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle()
    {
        try {
            $payload = JWTEncrypt::encrypt([
                'quiz_id' => config('quiz.id'),
                'user_uuid' => $this->paper->participant->user->uuid,
                'record' => [
                    'score' => $this->paper->score,
                    'seconds' => $this->paper->seconds_used * 1000,
                    'recorded_at' => $this->paper->finished_at,
                    'reference' => $this->paper->id,
                ]
            ]);

            $client = new HttpClient([
                'verify' => !app()->isLocal()
            ]);

            $client->request('POST', config('quiz.api_url')."/v1/quiz-records", [
                'form_params' => [
                    'app_id' => config('sso.access_key'),
                    'payload' => $payload
                ]
            ]);
        } catch (\Exception $exception) {
            \Log::error("Failed to get user info from core. Error: {$exception->getMessage()}");

            abort(500);
        }
    }
}
