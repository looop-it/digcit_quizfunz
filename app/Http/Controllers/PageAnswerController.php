<?php

namespace App\Http\Controllers;

use App\Events\CompetitionFinished;
use App\Facades\PaperManager;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Cache;

class PageAnswerController extends Controller
{
    public function show(Request $request)
    {
        if (!$this->enabled()) {
            abort(404);
        }

        $manager = $this->manager();

        if (!$manager) {
            return redirect()->route('competition.error')->with('message', '沒有可作答的試卷。');
        }

        if ($manager->isPaperTimeout()) {
            return redirect()->route('competition.result');
        }

        $this->settleTimedOutQuestions($manager);

        if ($manager->isFinished() || $manager->isPaperTimeout()) {
            return redirect()->route('competition.result');
        }

        $question = $manager->getQuestion();

        if (!$question) {
            return redirect()->route('competition.result');
        }

        $decoded = json_decode($question['options'], true) ?: [];
        $options = array_keys($decoded);
        shuffle($options);

        $meta = $manager->buildInitializeResponse();
        $remain = (int) $meta['seconds_per_questions'] - (int) $question['start_time_offset'];

        if ($remain < 0) {
            $remain = 0;
        }

        return view('competition.page', [
            'token' => $this->issueToken($manager, $question['paper_question_id']),
            'question' => $question,
            'options' => $options,
            'totalQuestions' => $meta['questions_per_paper'],
            'remainSeconds' => $remain,
            'previous' => $request->session()->pull('page_answer_previous'),
        ]);
    }

    public function submit(Request $request)
    {
        if (!$this->enabled()) {
            abort(404);
        }

        $manager = $this->manager();

        if (!$manager) {
            return redirect()->route('competition.error')->with('message', '沒有可作答的試卷。');
        }

        $question = $manager->getQuestion();

        if (!$question) {
            return redirect()->route('competition.result');
        }

        $stored = Cache::get($this->tokenKey($manager));

        if (!$stored || !hash_equals((string) $stored['token'], (string) $request->input('token'))) {
            return redirect()->route('competition.start')->withErrors(['提交憑證無效，請重新作答這一題。']);
        }

        if ((int) $stored['paper_question_id'] !== (int) $question['paper_question_id']
            || (int) $request->input('paper_question_id') !== (int) $question['paper_question_id']) {
            return redirect()->route('competition.start')->withErrors(['題目已經更換，請重新作答。']);
        }

        $decoded = json_decode($question['options'], true) ?: [];
        $correct = array_search(true, $decoded);
        $answer = $request->input('answer');
        $answer = ($answer === null || $answer === '') ? null : $answer;

        $manager->storeAnswer([
            'paper_question_id' => $question['paper_question_id'],
            'started_at' => $question['start_time'],
            'finished_at' => now()->format('Y-m-d H:i:s'),
            'answer' => $answer === null ? null : [$answer],
        ]);

        Cache::forget($this->tokenKey($manager));

        if ($manager->isFinished()) {
            event(new CompetitionFinished($manager->cache->getPaper(), now()));

            return redirect()->route('competition.result');
        }

        return redirect()->route('competition.start')->with('page_answer_previous', [
            'correct' => $correct,
            'selected' => $answer,
        ]);
    }

    private function enabled()
    {
        return config('competition.answer_mode') === 'page';
    }

    private function manager()
    {
        $user = Auth::user();
        $paperId = $user->getCurrentPaperId();

        if ($paperId) {
            return PaperManager::boot($paperId);
        }

        $paper = $user->papers()->where('status', 'assigned')->first();

        if (!$paper) {
            return null;
        }

        $manager = PaperManager::setPaperId($paper->id);

        if (!$manager->setPaperProcessing($paper)) {
            return null;
        }

        $manager->setPaper();
        $user->setCurrentPaperId($paper->id);

        return $manager;
    }

    private function settleTimedOutQuestions($manager)
    {
        $guard = 0;

        while (!$manager->isFirstQuestion() && $manager->isQuestionTimeout() && $guard < 50) {
            $question = $manager->getQuestion();

            if (!$question) {
                return;
            }

            $manager->storeAnswer([
                'paper_question_id' => $question['paper_question_id'],
                'answer' => null,
                'started_at' => $question['start_time'],
                'finished_at' => now()->format('Y-m-d H:i:s'),
            ]);

            Cache::forget($this->tokenKey($manager));

            if ($manager->isFinished()) {
                event(new CompetitionFinished($manager->cache->getPaper(), now()));

                return;
            }

            $guard++;
        }
    }

    private function issueToken($manager, $paperQuestionId)
    {
        $key = $this->tokenKey($manager);
        $stored = Cache::get($key);

        if ($stored && (int) $stored['paper_question_id'] === (int) $paperQuestionId) {
            return $stored['token'];
        }

        $token = str_random(40);

        Cache::put($key, [
            'token' => $token,
            'paper_question_id' => (int) $paperQuestionId,
        ], 30);

        return $token;
    }

    private function tokenKey($manager)
    {
        $paper = $manager->cache->getPaper();

        return 'page-answer:'.Auth::id().':'.$paper->id;
    }
}
