<?php

namespace App\Jobs;

use Illuminate\Bus\Queueable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use App\Models\Paper;
use Illuminate\Support\Facades\DB;

class FinishPaper implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    public $paper;
    public $finishedAt;

    /**
     * Create a new job instance.
     */
    public function __construct(Paper $paper, $finishedAt)
    {
        $this->paper = $paper;
        $this->finishedAt = $finishedAt;
    }

    /**
     * Execute the job.
     */
    public function handle()
    {
        if ($this->paper->isProcessing()) {
            try {
                DB::transaction(function () {
                    $this->paper->update([
                        'status' => 'reviewing',
                        'finished_at' => $this->finishedAt,
                    ]);
                }, 5);
            } catch (\Exception $exception) {
                \Log::error("Failed to set paper status to reviewing. Paper ID: {$this->paper->id}. Error: {$exception->getMessage()}");
            }
        } else {
            \Log::error("Try to finish a paper which status is not processing. Paper ID: {$this->paper->id}. Status: {$this->paper->status}");
        }
    }
}
