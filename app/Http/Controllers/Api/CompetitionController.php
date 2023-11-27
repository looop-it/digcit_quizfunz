<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;
use App\Facades\PaperManager;
use App\Exceptions\PaperCacheException;
use App\Http\Requests\SubmitAnswer;
use Illuminate\Support\Facades\Cache;
use App\Models\Paper;
use App\Events\CompetitionFinished;

class CompetitionController extends Controller
{
    public function __construct()
    {
        $this->middleware(function ($request, $next) {
            $this->user = Auth::user();
            
            return $next($request);
        });
    }

    public function login(Request $request)
    {
        $user = Auth::loginUsingId($request->id);

        if ($user) {
            return response()->json([
                'status' => 200,
                'data' => $user
            ]);
        }
    }

    public function getUser(Request $request)
    {
        $user = Auth::user();

        if ($user) {
            return response()->json([
                'status' => 200,
                'data' => $user
            ]);
        }
    }

    public function logout(Request $request)
    {
        Auth::guard()->logout();

        return response()->json([
            'status' => 200,
            'message' => 'Logged out.'
        ]);
    }

    /**
     * Initialize competition.
     *
     * @return void
     */
    public function initialize()
    {
        try {
            $paper = $this->user->papers->where('status', 'assigned')->first();

            if (!$paper) {
                // $paper = PaperManager::assignPaper($this->user);
                return response()->json([
                    'status' => '500',
                    'message' => 'No paper assigned.'
                ], 500);
            }
            
            if ($paper) {
                $paperManager = PaperManager::setPaperId($paper->id);

                $result = $paperManager->setPaperProcessing($paper);

                if ($result) {
                    // Cache paper with paper questions & season.
                    $paper = $paper->fresh()->load('questions', 'season');

                    // $paperManager->cachePaper($paper);
                    
                    $paperManager->setPaper();

                    // Cache user's current paper id.
                    $this->user->setCurrentPaperId($paper->id);
                    
                    return response()->json(
                        $paperManager->buildInitializeResponse(),
                        200
                    );
                }
            }
        } catch (\Exception $exception) {
            \Log::error('Failed to initialize paper. Error: ' . $exception->getMessage());

            return response()->json([
                'status' => '500',
                'message' => 'Failed to initialize competition.'
            ], 500);
        }

        return response()->json([
            'status' => '404',
            'message' => 'No assigned paper found.'
        ], 200);
    }

    /**
     * Get paper question.
     *
     * @return void
     */
    public function getQuestion(Request $request)
    {
        try {
            $paperManager = PaperManager::setPaperId($this->user->getCurrentPaperId())
                                        ->setPaper();

            $question = $paperManager->getQuestion();

            if ($question) {
                return response()->json($paperManager->buildQuestionResponse($question), 200);
            }
        } catch (\Exception $exception) {
            \Log::error("Failed to get question. Paper ID: {$this->user->getCurrentPaperId()}. Error: {$exception->getMessage()}");

            return response()->json([
                'status' => 500,
                'message' => 'Failed to get question.'
            ], 500);
        }

        return response()->json([
            'status' => 404,
            'message' => 'No more question found in paper.'
        ], 200);
    }

    /**
     * Submit answer.
     *
     * @param SubmitAnswer $request
     * @return void
     */
    public function submitAnswer(SubmitAnswer $request)
    {
        try {
            $paperManager = PaperManager::setPaperId($this->user->getCurrentPaperId());
            $question = $paperManager->getQuestion();

            // Validate user in correct flow.
            if ($question['paper_question_id'] != $request->paper_question_id) {
                \Log::error(
                    "Invalid request data. 
                    Cached PQ ID: {$question['paper_question_id']}. 
                    Request PQ ID: {$request->paper_question_id}
                    User paper ID: {$this->user->getCurrentPaperId()}" .
                    'Question cache: ' . json_encode($question, JSON_UNESCAPED_UNICODE) .
                    'Requst Data: ' . json_encode($request->all(), JSON_UNESCAPED_UNICODE)
                );

                return response()->json([
                    'status' => 422,
                    'message' => 'Invalid request data.'
                ], 422);
            }
            
            $paperManager->storeAnswer([
                'paper_question_id' => $question['paper_question_id'],
                'started_at' => $question['start_time'],
                'finished_at' => now()->format('Y-m-d H:i:s'),
                'answer' => $request->answer
            ]);
        } catch (\Exception $exception) {
            \Log::error("Failed to submit answer. Error: {$exception->getMessage()}");

            return response()->json([
                'status' => 500,
                'message' => 'Failed to submit answer.'
            ], 500);
        }

        // Check if paper finished
        $isFinished = $paperManager->isFinished();

        if ($isFinished) {
            // Dispatch event CompetitionFinished
            $paper = $paperManager->cache->getPaper();
            event(new CompetitionFinished($paper, now()));
        }

        return response()->json([
            'status' => 200,
            'finished' => $isFinished,
            'correct_answer' => array_search(true, json_decode($question['options'], true)),
            'message' => 'Answer has been submitted.'
        ]);
    }

    /**
     * Get result of paper.
     *
     * @return void
     */
    public function getResult()
    {
        $paper = $this->user->papers()
                    ->whereIn('status', ['processing', 'reviewing', 'finished'])
                    ->orderBy('started_at', 'desc')
                    ->first();

        if ($paper) {
            if ($paper->isProcessing()) {
                return response()->json([
                    'status' => 422,
                    'messsage' => 'Paper finish jobs are being processed.'
                ], 200);
            }

            if ($paper->isReviewing()) {
                return response()->json([
                    'status' => 422,
                    'messsage' => 'Paper is being reviewed.'
                ], 200);
            }

            if ($paper->isFinished()) {
                return response()->json([
                    'status' => 200,
                    'seconds_used' => $paper->seconds_used,
                    'score' => $paper->score,
                    'questions_answered' => $paper->questions_answered
                ], 200);
            }
        }

        return response()->json([
            'status' => 404,
            'message' => 'No paper found'
        ], 200);
    }
}
