<?php

namespace App\Http\Middleware;

use Closure;
use App\Facades\PaperManager;
use App\Events\CompetitionFinished;

class CheckQuestionTimeout extends Middleware
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle($request, Closure $next)
    {
        $paperManager = PaperManager::boot($this->getUserPaperId());

        // When processing question is timeout
        if ($paperManager->isQuestionTimeout()) {
            $question = $paperManager->getQuestion();

            // When answer is timeout, set answer to null
            $paperManager->storeAnswer([
                'paper_question_id' => $question['paper_question_id'],
                'answer' => null,
                'started_at' => $question['start_time'],
                'finished_at' => now()->format('Y-m-d H:i:s'),
            ]);

            // Check if paper finished
            if ($paperManager->isFinished()) {
                // Dispatch event CompetitionFinished
                $paper = $paperManager->cache->getPaper();
                event(new CompetitionFinished($paper, now()));

                return response()->json([
                    'status' => 404,
                    'message' => 'No more question found in paper.'
                ], 200);
            }
        }

        // Continue to get new question
        return $next($request);
    }
}
