<?php

namespace App\Console\Commands;

use Carbon\Carbon;
use App\Models\Paper;
use App\Models\Question;
use App\Jobs\CalcQuestionHitRate;
use Illuminate\Console\Command;

class QuestionCalcHitRate extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'question:calc-hit-rate';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Calc question hit rate from answered papers';

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
        // Check if has any finished papers in past 5 minutes
        $newPapersCount = Paper::finished()->where('finished_at', '>=', Carbon::now()->subMinutes(5))->count();
        if ($newPapersCount > 0) {
            $questions = Question::all();

            $bar = $this->output->createProgressBar($questions->count());
            $bar->start();
            foreach ($questions as $question) {
                CalcQuestionHitRate::dispatch($question);
                $bar->advance();
            }
            $bar->finish();
        }
    }
}
