<?php

namespace App\Helpers;

use App\Contracts\Cache\Competition as CompetitionCache;
use App\Models\Paper;
use App\Models\Season;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;

class PaperManager
{
    public $cache;
    private $paper;
    private $questionIndex;

    public function __construct(CompetitionCache $cache)
    {
        $this->cache = $cache;
    }

    public function boot($paperId)
    {
        $this->setPaperId($paperId)->setPaper();

        return $this;
    }

    public function setPaperId($paperId)
    {
        $this->cache = $this->cache->setPaperId($paperId);

        return $this;
    }

    public function setPaper()
    {
        $this->paper = $this->cache->getPaper();

        return $this;
    }

    /**
     * Assign a created paper to user.
     */
    public function assignPaper(User $user): ?Paper
    {
        DB::beginTransaction();

        try {
            $paper = $this->getAvaiablePaper();

            // When there is available paper.
            // Assign the paper to the user.
            if ($paper) {
                $paper->update([
                    'participant_id' => $user->participant->id,
                    'status' => 'assigned',
                ]);

                DB::commit();

                return $paper;
            }

            // TODO: notify IT team to generate more papers.
        } catch (\Exception $exception) {
            DB::rollback();

            \Log::error("Failed to assign paper to user. User id: {$user->id}. Error: {$exception->getMessage()}");
        }

        return null;
    }

    /**
     * Get created paper which is available for assigning to user.
     *
     * @return void
     */
    private function getAvaiablePaper()
    {
        return Paper::where([
            ['season_id', season()->id],
            ['status', 'created'],
            ['participant_id', null],
        ])->first();
    }

    /**
     * Set paper status to processing.
     */
    public function setPaperProcessing(Paper $paper): bool
    {
        DB::beginTransaction();

        try {
            $paper->update([
                'status' => 'processing',
                'started_at' => now(),
            ]);

            DB::commit();

            return true;
        } catch (\Exception $exception) {
            DB::rollback();

            \Log::error("Failed to set paper status to processing. Paper ID: {$paper->id}. Error: {$exception->getMessage()}");
        }

        return false;
    }

    /**
     * Store paper record to cache.
     *
     * @return void
     */
    public function cachePaper(Paper $paper)
    {
        return $this->cache->setPaper($paper);
    }

    /**
     * Get question from cached paper.
     *
     * @return void
     */
    public function getQuestion()
    {
        $this->setQuestionIndex();

        $question = $this->paper->questions->get($this->questionIndex) ?? null;

        if ($question) {
            $data = $this->buildQuestionDataSet($question);

            // if ($this->isFirstQuestion()) {
            //     event(new CompetitionStarted($paper));
            // }

            return $data;
        }

        return null;
    }

    private function setQuestionIndex()
    {
        $this->questionIndex = $this->cache->countCachedAnswers();
    }

    /**
     * Build question data set for caching.
     *
     * @param [type] $question
     */
    private function buildQuestionDataSet($question): array
    {
        $startTime = $this->getQuestionStartTime();
        $startTimeOffset = now()->diffInSeconds($startTime);

        // Make sure no negative offset;
        if ($startTimeOffset < 0) {
            $startTimeOffset = 0;
        }

        return [
            'id' => $this->questionIndex + 1,
            'paper_question_id' => $question->pivot->id,
            'name' => $question->name,
            'options' => $question->pivot->options,
            'start_time' => $startTime,
            'start_time_offset' => $startTimeOffset,
        ];
    }

    private function getQuestionStartTime()
    {
        if ($this->isFirstQuestion()) {
            return $this->getPaperStartTime();
        }

        // get last answer cache finished_at
        if (!$this->questionIndex) {
            $this->setQuestionIndex();
        }

        $question = $this->cache->getQuestionDetail($this->questionIndex);

        if ($question) {
            // Add one second to eliminate network latency between requests.
            return Carbon::parse($question['finished_at'])->addSeconds(1)->format('Y-m-d H:i:s');
        }

        return null;
    }

    /**
     * Check if getting first question.
     */
    public function isFirstQuestion(): bool
    {
        if ($this->cache->countCachedAnswers() == 0) {
            return true;
        }

        return false;
    }

    /**
     * Get paper start time from cache.
     *
     * @return string
     */
    private function getPaperStartTime()
    {
        return $this->paper->started_at ?? null;
    }

    /**
     * Build question response.
     *
     * @param [type] $question
     *
     * @return array
     */
    public function buildQuestionResponse($question)
    {
        // TODO: support multiple select in the future
        $question['multiple_select'] = false;
        $question['options'] = array_keys(json_decode($question['options'], true));

        return [
            'status' => 200,
            'question' => $question,
        ];
    }

    /**
     * Store answer to cache.
     *
     * @return void
     */
    public function storeAnswer(array $data)
    {
        // $data = array_merge($data, [
        //     'finished_at' => now()->format('Y-m-d H:i:s'),
        //     'timeout' => $this->isQuestionTimeout()
        // ]);

        $this->cache->setAnswer($data);
    }

    /**
     * Check if paper is time out for answering.
     *
     * @return bool
     */
    public function isPaperTimeout()
    {
        if (now()->diffInSeconds($this->getPaperStartTime()) - $this->paper->season->paper_time_limit <= config('competition.global.paper_time_limit_buffer')) {
            return false;
        }

        return true;
    }

    /**
     * Check if question is time out.
     *
     * @return bool
     */
    public function isQuestionTimeout($withBuffer = false)
    {
        if ($this->isFirstQuestion()) {
            return false;
        }

        $timeLimit = $this->paper->season->question_time_limit;

        if ($withBuffer) {
            $timeLimit = $timeLimit + config('competition.global.question_time_limit_buffer');
        }

        if (now()->diffInSeconds($this->getQuestionStartTime()) < $timeLimit) {
            return false;
        }

        return true;
    }

    /**
     * Check if the paper is finished.
     */
    public function isFinished(): bool
    {
        if ($this->cache->countCachedAnswers() >= $this->getTotalQuestions()) {
            return true;
        }

        return false;
    }

    /**
     * Build initialize response.
     */
    public function buildInitializeResponse(): array
    {
        $paperStartTime = $this->getPaperStartTime();

        return [
            'status' => 200,
            'paper_start_time' => Carbon::parse($paperStartTime)->format('Y-m-d H:i:s'),
            'paper_start_time_offset' => now()->diffInseconds($paperStartTime),
            'seconds_per_questions' => $this->paper->season->question_time_limit,
            'questions_per_paper' => $this->getTotalQuestions(),
        ];
    }

    /**
     * Check if processing paper exists in cache.
     */
    public function hasProcessingPaper(): bool
    {
        return $this->cache->isCacheKeyExists(
            $this->cache->getPaperCacheKey()
        );
    }

    /**
     * Get total questions of paper in season.
     */
    private function getTotalQuestions(): int
    {
        return $this->paper->season->general_questions * 1 + $this->paper->season->other_questions * 11;
    }

    /**
     * Archive paper answers to OSS.
     *
     * @return void
     */
    public function archiveAnswers(int $seasonId, string $paperNumber)
    {
        try {
            $answers = $this->cache->getAnswer();

            if ($answers) {
                asort($answers);

                $result = Storage::disk('answers')->put(
                    env('APP_NAME', 'Laravel')."_season_{$seasonId}/{$paperNumber}.json",
                    json_encode($answers, JSON_UNESCAPED_UNICODE)
                );

                return $result;
            }

            return false;
        } catch (\Exception $exception) {
            \Log::error('Failed to archive answer cache. Error: '.$exception->getMessage());

            return;
        }
    }
}
