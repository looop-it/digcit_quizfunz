<?php

namespace App\Jobs;

use App\Models\Question;
use Illuminate\Bus\Queueable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;

class CalcQuestionCorrectRate implements ShouldQueue
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
        $question = $this->question;
        // Get all related papers
        $relatedPapers = $question->papers()->where('status', 'finished')->get();
        // Get total count
        $totalNum = $relatedPapers->count();
        // Get correct count
        $correctNum = $relatedPapers->where('pivot.correct', 1)->count();
        // Calc correct rate in percentage
        $correctRate = ($totalNum == 0 || $correctNum == 0) ? 0 : (round($correctNum/$totalNum, 2)*100);
        $question->correct_rate = $correctRate;
        $question->save();
    }
}
