<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Models\PaperQuestion;
use Carbon\Carbon;

class PaperSimulateAnswer extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'paper:simulate-answer';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Simulate question answer (Development mode only)';

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
        if (config('app.env') != 'local') {
            return $this->error('Fatal: this command only work in local mode.');
        }

        $questions = PaperQuestion::whereNull('answer')
                                    ->whereNull('started_at')
                                    ->whereNull('finished_at')
                                    ->get();

        $totalQuestions = count($questions);

        $bar = $this->output->createProgressBar($totalQuestions);
        $bar->start();

        $questions->each(function ($paperQuestion) use ($bar, & $finishedAt) {
            $startedAt = $finishedAt ?? new \DateTimeImmutable();

            // Get one random option in options
            // TODO: Get multiple answer
            $answer = (rand(1, 5) == 5) ? null : [array_rand($paperQuestion->options, 1)];

            $finishedAt = $this->getRandomFinishedAt($answer, $startedAt);

            // Update answer
            $paperQuestion->update([
                'answer' => $answer,
                'started_at' => $startedAt,
                'finished_at' => $finishedAt
            ]);

            $bar->advance();
        });

        $bar->finish();

        $this->info('');
        $this->info('Completed.');
    }

    /**
     * Get random finished_at depends on answer & started_at.
     *
     * @return \DateTimeImmutable
     */
    private function getRandomFinishedAt($answer, $startedAt)
    {
        $secondsUsed = rand(5, 40);

        if (is_null($answer) || $secondsUsed > 30) {
            $secondsUsed = 30;
        }

        return $startedAt->add(new \DateInterval("PT{$secondsUsed}S"));
    }
}
