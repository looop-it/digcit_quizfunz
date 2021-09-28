<?php

namespace App\Jobs\Competition;

use Illuminate\Bus\Queueable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;

use App\Models\Paper;
use Illuminate\Support\Facades\DB;

class ScorePaper implements ShouldQueue
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
        if ($this->paper->isReviewing()) {
            try {
                DB::transaction(function () {
                    $paperQuestions = $this->paper->paperQuestions;

                    $this->paper->update([
                        'status' => 'finished',
                        'score' => $paperQuestions->sum('score'),
                        'seconds_used' => $paperQuestions->sum('seconds_used'),
                        // TODO: Calculate effective questions
                    ]);
                }, 5);
            } catch (\Exception $exception) {
                \Log::error("Failed to score paper. Paper ID: {$this->paper->id}. Error: {$exception->getMessage()}");
            }
        } else {
            \Log::error("Try to score a paper which status is not reviewing. Status: {$this->paper->status}");
        }
    }
}
