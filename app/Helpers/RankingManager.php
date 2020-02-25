<?php

namespace App\Helpers;

use Illuminate\Support\Facades\Redis;

class RankingManager
{
    public function __construct()
    {
        $this->connection = 'paper';
    }

    public function setSeasonId($seasonId)
    {
        $this->seasonId = $seasonId;

        return $this;
    }

    public function setCache($field, $data)
    {
        Redis::connection($this->connection)->command('hset', [
            $this->getCacheKey(),
            $field,
            serialize($data)
        ]);

        // Update last update at
        Redis::connection($this->connection)->command('hset', [
            $this->getCacheKey(),
            'lastUpdatedAt',
            now()
        ]);
    }

    /**
     * [getRankingCache description]
     * @param  String $field
     * @return collection | null
     */
    public function getCache($field)
    {
        $data = Redis::connection($this->connection)->command('hget', [$this->getCacheKey(), $field]);

        return ($data) ? unserialize($data) : null;
    }

    public function getAllRanking()
    {
        $data = Redis::connection($this->connection)->hgetall($this->getCacheKey());

        if ($data) {
            foreach ($data as $key => $value) {
                if ($key <> 'lastUpdatedAt') {
                    $data[$key] = unserialize($value);
                }
            }
            return $data;
        }
        
        return null;
    }

    /**
     * getRankingUpdatetime
     * @return time | null
     */
    public function getLastUpdatedAt()
    {
        return Redis::connection($this->connection)->command('hget', [$this->getCacheKey(), 'lastUpdatedAt']);
    }

    private function getCacheKey()
    {
        return "season:{$this->seasonId}:ranking";
    }
}
