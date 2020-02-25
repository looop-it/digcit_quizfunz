<?php

namespace App\Jobs;

use Illuminate\Bus\Queueable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;

use App\Models\Paper;
use Illuminate\Support\Facades\DB;
use App\Models\PaperQuestion;

use Carbon\Carbon;

class JudgePaperQuestions implements ShouldQueue
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
            $questions = $this->paper->paperQuestions;

            foreach ($questions as $question) {
                $this->judge($question);
            }
        } catch (\Exception $exception) {
            \Log::error("Failed to judge paper questions. Paper ID: {$this->paper->id}. Error: {$exception->getMessage()}");

            return;
        }

        // Dipatch job to score paper.
        ScorePaper::dispatch($this->paper)->delay(now()->addSeconds(2));
    }

    /**
     * Judge question.
     *
     * @param PaperQuestion $question
     * @return void
     */
    private function judge(PaperQuestion $question)
    {
        try {
            DB::transaction(function () use ($question) {
                $secondsUsed = $this->getSecondsUsed($question);
                $isTimeout = $this->isTimeout($question, $secondsUsed);
                $isCorrect = $this->isCorrect($question);
                $score = $this->getScore($isTimeout, $isCorrect);

                $question->update([
                    'seconds_used' => $isTimeout ? $this->paper->season->question_time_limit : $secondsUsed,
                    'correct' => $isCorrect,
                    'score' => $score
                ]);
            }, 5);
        } catch (\Exception $exception) {
            \Log::error("Failed to judge paper question. ID: {$question->id}. Error: {$exception->getMessage()}");
        }
    }
    /**
     * Get seconds used of questions.
     *
     * @param \App\Models\PaperQuestion $question
     * @return void
     */
    private function getSecondsUsed(PaperQuestion $question) : int
    {
        // No answer, return max seconds.
        if (!$question->answer || !$question->started_at || !$question->finished_at) {
            return $this->paper->season->question_time_limit;
        }

        $seconds = Carbon::parse($question->finished_at)->diffInSeconds(Carbon::parse($question->started_at));

        if ($seconds <= 0) {
            return 1;
        }

        return $seconds;
    }

    /**
     * Check questions is timeout.
     *
     * @param integer $seconds
     * @return boolean
     */
    private function isTimeout(PaperQuestion $question, int $seconds) : bool
    {
        if (!$question->answer) {
            return true;
        }

        return $seconds > $this->paper->season->question_time_limit;
    }

    /**
     * Judge whether answers submitted by user are correct.
     *
     * @param array $options
     * @param array $answers
     * @return boolean
     */
    private function isCorrect(PaperQuestion $question)
    {
        if (!$question->answer) {
            return false;
        }

        $trueOptions = array_keys(
            array_where(
                $question->options,
                function ($value, $key) {
                    return $value === true;
                }
            )
        );

        foreach ($question->answer as $answer) {
            if (!in_array($answer, $trueOptions)) {
                return false;
            }
        }

        return true;
    }

    /**
     * Calculate score.
     *
     * @param array $options
     * @param array|null $answers
     * @param boolean $timeout
     * @return integer
     */
    private function getScore(bool $timeout, bool $correct) : int
    {
        if ($timeout || !$correct) {
            return 0;
        }

        return $this->paper->season->question_score;
    }
}
