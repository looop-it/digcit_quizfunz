<?php

namespace App\Jobs;

use Illuminate\Bus\Queueable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use App\Models\UserStat;
use App\Models\User;
use Illuminate\Support\Facades\Redis;
use Illuminate\Support\Facades\DB;

class StoreUserStatFromCache implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    public $user;
    public $redis;

    /**
     * Create a new job instance.
     *
     * @return void
     */
    public function __construct(User $user)
    {
        $this->user = $user;
        $this->redis = Redis::connection('user_stats');
    }

    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle()
    {
        $stats = $this->redis->lrange($this->getCacheKey(), 0, -1);

        if (count($stats) > 0) {
            foreach ($stats as $stat) {
                DB::transaction(function () use ($stat) {
                    UserStat::create($this->buildStatDataSet($stat));
                }, 5);
            }

            $this->redis->del($this->getCacheKey());
        }
    }

    /**
     * Build clear data set of user stat.
     *
     * @param string $stat
     * @return array
     */
    private function buildStatDataSet(string $stat) : array
    {
        $stat = unserialize($stat);
    
        $data = [
            'user_id' => $this->user->id,
            'page' => $stat['page'],
            'ip' => $stat['ip'],
            'created_at' => $stat['date']
        ];

        unset($stat['page']);
        unset($stat['ip']);
        unset($stat['date']);

        $data['stats'] = $stat;

        return $data;
    }

    /**
     * Get stat cache key.
     *
     * @return string
     */
    private function getCacheKey() : string
    {
        return "user:{$this->user->id}:stats";
    }
}
