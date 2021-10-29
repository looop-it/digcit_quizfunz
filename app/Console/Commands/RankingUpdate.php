<?php

namespace App\Console\Commands;

use App\Jobs\UpdateRankingCache;
use App\Models\Season;
use Illuminate\Console\Command;

class RankingUpdate extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'ranking:update
                            {season? : The ID of season }';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'update season ranking';

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct()
    {
        parent::__construct();
    }

    /**
     * Execute the console command.
     *
     * @return mixed
     */
    public function handle()
    {
        $seasonId = $this->argument('season');

        if (!$seasonId) {
            $season = latestSeason();
        } else {
            $season = $this->getSeason($seasonId);
        }

        if (!$season) {
            return $this->error('No available season! Please double confirm!!');
        }

        UpdateRankingCache::dispatch($season->id);

        $this->info('UpdateRankingCache job dispatched.');
    }

    private function getSeason($seasonId)
    {
        return Season::where('id', intval($seasonId))
                    ->whereIn('status', ['open', 'closed'])
                    ->first();
    }
}
