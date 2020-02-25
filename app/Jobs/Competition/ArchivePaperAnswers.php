<?php

namespace App\Jobs;

use Illuminate\Bus\Queueable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;

use App\Models\Paper;
use App\Facades\PaperManager;

class ArchivePaperAnswers implements ShouldQueue
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
        if ($this->paper->isFinished()) {
            $paperManager = PaperManager::setPaperId($this->paper->id);

            if ($paperManager->archiveAnswers($this->paper->season_id, $this->paper->number)) {
                // $paperManager->cache->clearAnswer();
            }
        } else {
            \Log::error("Try to archive anwers of  a paper which status is not finished. Status: {$this->paper->status}");
        }
    }
}
