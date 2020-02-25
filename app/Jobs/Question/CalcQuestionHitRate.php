<?php

namespace App\Jobs;

use App\Models\Paper;
use App\Models\Question;
use Illuminate\Bus\Queueable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;

class CalcQuestionHitRate implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    public $question;

    /**
     * Create a new job instance.
     *
     * @return void
     */
    public function __construct(Question $question)
    {
        $this->question = $question;
    }

    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle()
    {
        // Get all finished paper count
        $totalPaperCount = Paper::finished()->count();

        $question = $this->question;
        // Get all related papers
        $relatedPaperCount = $question->papers()->where('status', 'finished')->count();
        // Calc correct rate in percentage
        $hitRate = ($totalPaperCount == 0 || $relatedPaperCount == 0) ? 0 : (round($relatedPaperCount/$totalPaperCount, 2)*100);
        $question->hit = $hitRate;
        $question->save();
    }
}
