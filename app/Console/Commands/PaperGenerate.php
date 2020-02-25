<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Jobs\GeneratePaper;
use App\Models\Season;

class PaperGenerate extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'paper:generate {number?} {season?}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Genearte paper';

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
        $number = $this->argument('number');

        if (!$number) {
            $number = $this->ask('How many papers do you want to generate?', 50);
        }

        $seasonId = $this->argument('season');

        if (!$seasonId) {
            $seasonId = $this->ask('Which season id these papers generate for?', 'latest');
        }

        $season = $this->getSeason($seasonId);

        if (!$season) {
            return $this->error('Season id provided is not valid! Please double confirm!!');
        }
        
        if ($number > 0 && $number <= 1000) {
            $bar = $this->output->createProgressBar($number);

            $bar->start();

            for ($i=0; $i < $number; $i++) {
                GeneratePaper::dispatch($season);
                $bar->advance();
            }

            $bar->finish();

            $this->info('Complete.');
        } else {
            $this->error('Input must > 0 and < 1000.');
        }
    }

    private function getSeason($seasonId)
    {
        if ($seasonId == 'latest') {
            return Season::open()->latest()->first();
        }

        return Season::where('id', intval($seasonId))->whereIn('status', ['ready', 'open'])->first();
    }
}
