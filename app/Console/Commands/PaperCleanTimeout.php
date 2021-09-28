<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;

use App\Models\Paper;
use App\Jobs\Competition\FinishPaper;
use App\Models\Season;

class PaperCleanTimeout extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'paper:clean-timeout {--force}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Clean the papers in current open season which over max time limit';

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
        $isForce = $this->option('force');

        $season = season();

        if ($isForce) {
            $papers = $season->papers()->processing()->get();
        } else {
            $papers = $season->papers()->timeout($season->paper_time_limit)->get();
        }

        if ($papers) {
            $totalPapers = count($papers);

            $bar = $this->output->createProgressBar($totalPapers);
            $bar->start();

            foreach ($papers as $paper) {
                dispatch(new FinishPaper($paper, now()));

                $bar->advance();
            }
        }
    }
}
