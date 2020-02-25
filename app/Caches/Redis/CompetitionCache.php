<?php

namespace App\Caches\Redis;

use App\Contracts\Cache\Competition as CacheInterface;
use Illuminate\Support\Facades\Redis;
use App\Exceptions\PaperCacheException;
use App\Models\Paper;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Cache;
use App\Models\Season;

class CompetitionCache implements CacheInterface
{
    private $connection;
    private $paperId;
    
    public function __construct()
    {
        $this->connection = 'paper';
    }
    
    public function setConnection($connection)
    {
        $this->connection = $connection;

        return $this;
    }

    public function setPaperId($paperId)
    {
        $this->paperId = $paperId;

        return $this;
    }

    /**
     * Store paper data to cache.
     *
     * @return void
     */
    public function setPaper(Paper $paper)
    {
        try {
            // TODO: remove unneccessary data from paper questions.
            Redis::connection($this->connection)->set(
                "paper:{$paper->id}",
                $this->serialize($paper)
            );
        } catch (\Exception $exception) {
            \Log::error("Failed to set paper cache. Paper ID: {$paper->id}. Error: {$exception->getMessage()}");

            throw new PaperCacheException("Cannot cache paper.");
        }
    }

    /**
     * Get paper data from cache
     *
     * @return void
     */
    public function getPaper()
    {
        return Cache::remember($this->getPaperCacheKey(), 60, function () {
            return Paper::find($this->paperId);
        });

        // try {
        //     if ($this->isCacheKeyExists($this->getPaperCacheKey())) {
        //         $paper = Redis::connection($this->connection)->get(
        //             $this->getPaperCacheKey()
        //         );
    
        //         if ($paper) {
        //             return $this->unserialize($paper);
        //         }
        //     }

        //     $paper = Paper::find($this->paperId);

        //     return $paper ?? null;
        // } catch (\Exception $exception) {
        //     \Log::error("Failed to get paper cache. Paper ID: {$this->paperId}. Error: {$exception->getMessage()}");

        //     throw new PaperCacheException('Failed to get paper cache.');
        // }
    }

    /**
     * Clear paper cache.
     *
     * @return void
     */
    public function clearPaper()
    {
        return Cache::forget($this->getPaperCacheKey());

        // try {
        //     return $this->clearCache($this->getPaperCacheKey());
        // } catch (\Exception $exception) {
        //     \Log::error("Failed to clear paper cache. Paper ID: {$this->paperId}. Error: {$exception->getMessage()}");

        //     throw new PaperCacheException('Failed to clear paper cache.');
        // }
    }

    /**
     * Get paper cache key.
     *
     * @return string
     */
    private function getPaperCacheKey() : string
    {
        return "paper:{$this->paperId}";
    }

    /**
     * Get current answering question cache id.
     *
     * @return string
     */
    public function getQuestionCacheKey() : string
    {
        return "paper:{$this->paperId}:question";
    }

    /**
     * Cache answer to hash set.
     *
     * @param array $data
     * @return void
     */
    public function setAnswer(array $data)
    {
        try {
            $key = $this->countCachedAnswers() + 1;

            Redis::connection($this->connection)->command('hsetnx', [
                $this->getAnswerCacheKey(),
                "question:{$key}",
                $this->serialize($data)
            ]);
        } catch (\Exception $exception) {
            \Log::error(
                "Failed to set answer cache. Paper ID: {$this->paperId}." .
                'Data: ' . json_encode($data, JSON_UNESCAPED_UNICODE) .
                "Error: {$exception->getMessage()}"
            );

            throw new PaperCacheException("Failed to set answer cache.");
        }
    }

    /**
     * Check if answer cache exists.
     *
     * @return boolean
     */
    public function isAnswerExists()
    {
        return $this->isCacheKeyExists($this->getAnswerCacheKey());
    }

    /**
     * Get all answers cached.
     *
     * @return void
     */
    public function getAnswer()
    {
        try {
            $answers = Redis::connection($this->connection)->hgetall(
                $this->getAnswerCacheKey()
            );

            if ($answers) {
                foreach ($answers as $key => $value) {
                    $answers[$key] = $this->unserialize($value);
                }
        
                return $answers;
            }

            return null;
        } catch (\Exception $exception) {
            \Log::error("Failed to get answer cache. Paper ID: {$this->paperId}. Error: {$exception->getMessage()}");

            throw new PaperCacheException("Failed to get answer cache.");
        }
    }

    public function getQuestionDetail($index)
    {
        try {
            $answer = Redis::connection($this->connection)->hget(
                $this->getAnswerCacheKey(),
                "question:{$index}"
            );

            if ($answer) {
                return $this->unserialize($answer);
            }

            return null;
        } catch (\Exception $exception) {
            \Log::error("Failed to get answer cache. Paper ID: {$this->paperId}. Error: {$exception->getMessage()}");

            throw new PaperCacheException("Failed to get answer cache.");
        }
    }

    /**
     * Delete answer cacde key.
     *
     * @return void
     */
    public function clearAnswer()
    {
        try {
            return $this->clearCache($this->getAnswerCacheKey());
        } catch (\Exception $exception) {
            \Log::error("Failed to clear answer cache. Paper ID: {$this->paperId}. Error: {$exception->getMessage()}");

            throw new PaperCacheException("Failed to clear answer cache.");
        }
    }

    /**
     * Get paper cache id.
     *
     * @return string
     */
    public function getAnswerCacheKey() : string
    {
        return "paper:{$this->paperId}:answers";
    }

    /**
     * Get number of answers cached.
     *
     * @return integer
     */
    public function countCachedAnswers() : int
    {
        if (!$this->isCacheKeyExists($this->getAnswerCacheKey())) {
            return 0;
        }
        
        $answers = Redis::connection($this->connection)->command('hkeys', [
            $this->getAnswerCacheKey()
        ]);

        return $answers ? count($answers) : 0;
    }

    /**
     * Delete cache by key.
     *
     * @param string $key
     * @return void
     */
    private function clearCache($key)
    {
        return Redis::connection($this->connection)->del($key);
    }

    /**
     * Check whether cache key exists.
     *
     * @param string $key
     * @return boolean
     */
    public function isCacheKeyExists(string $key) : bool
    {
        return Redis::connection($this->connection)->exists($key);
    }

    /**
     * Serialize the value.
     *
     * @param  mixed  $value
     * @return mixed
     */
    private function serialize($value)
    {
        return is_numeric($value) ? $value : serialize($value);
    }

    /**
     * Unserialize the value.
     *
     * @param  mixed  $value
     * @return mixed
     */
    private function unserialize($value)
    {
        return is_numeric($value) ? $value : unserialize($value);
    }
}
