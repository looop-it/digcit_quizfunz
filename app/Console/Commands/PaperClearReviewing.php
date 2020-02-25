<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Models\Paper;
use App\Jobs\JudgePaperQuestions;

class PaperClearReviewing extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'paper:clean-reviewing';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Clean paper which status stucks in reviewing';

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
        $season = season();

        $papers = Paper::inSeason($season->id)
                    ->reviewing()
                    ->where('finished_at', '<=', now()->subMinutes(1))
                    ->get();
                                
        foreach ($papers as $paper) {
            JudgePaperQuestions::dispatch($paper);
        }
    }
}
