<?php

namespace App\Jobs;

use Illuminate\Bus\Queueable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;

use App\Models\Paper;
use App\Facades\PaperManager;
use Illuminate\Support\Facades\DB;
use App\Models\PaperQuestion;
use Carbon\Carbon;
use App\Exceptions\PaperCacheException;

class StoreAnswerFromCache implements ShouldQueue
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
        $paperManager = PaperManager::setPaperId($this->paper->id);

        if ($paperManager->cache->isAnswerExists()) {
            $answers = $paperManager->cache->getAnswer();

            if ($answers) {
                foreach ($answers as $answer) {
                    if (is_array($answer)) {
                        $this->updatePaperQuestion($answer);
                    }
                }
            }
        } else {
            \Log::error("Failed to store answer due to absence of answer cache. Paper ID: {$this->paper->id}");
        }

        // Dipatch job to score paper.
        JudgePaperQuestions::dispatch($this->paper)->delay(now()->addSeconds(2));
    }

    /**
     * Update answer to paper question record.
     *
     * @param array $answer
     * @return void
     */
    private function updatePaperQuestion(array $answer)
    {
        try {
            DB::transaction(function () use ($answer) {
                $question = PaperQuestion::find($answer['paper_question_id']);

                if ($question) {
                    $question->update([
                        'answer' => $this->getAnswer($answer['answer']),
                        'started_at' => Carbon::parse($answer['started_at']),
                        'finished_at' => Carbon::parse($answer['finished_at'])
                    ]);
                } else {
                    \Log::error("Paper question cannot be found. Cached PQ ID: {$answer['paper_question_id']}. Data: " . json_encode($answer));
                }
            }, 5);
        } catch (\Exception $exception) {
            \Log::error("Failed to update paper question result. Cached PQ ID: {$answer['paper_question_id']}. Error: {$exception->getMessage()}. Data: " . json_encode($answer));
        }
    }

    /**
     * Get correct format of answer.
     *
     * @param array|null $answer
     * @return array|null
     */
    private function getAnswer(?array $answer) : ?array
    {
        return is_array($answer) ? $answer : null;
    }
}
