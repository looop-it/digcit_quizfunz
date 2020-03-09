<?php

namespace App\Console\Commands;

use App\Models\Season;
use App\Models\Participant;
use App\Jobs\UpdateWeeklyBasicScore;
use Illuminate\Console\Command;

class PanticipantUpdateWeeklyBasicScore extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'participant:update-weekly-basic-score {season?} {--force : Update previous weekly score forcely}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Update participants best weekly score and time to basic_scores table for weekly ranking calc';

    /**
     * Create a new command instance.
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
        $force = $this->option('force');

        $this->info($force);

        if (!$seasonId) {
            $seasonId = $this->ask('Which season id do you want to update?', 'latest');
        }

        $season = $this->getSeason($seasonId);

        if (!$season) {
            return $this->error('Season id provided is not valid! Please double confirm!!');
        }

        $bar = $this->output->createProgressBar(Participant::count());

        $bar->start();

        $season_id = $season->id;

        $result = Participant::latest()->chunk(500, function ($participants) use ($force, $season_id, $bar) {
            foreach ($participants as $participant) {
                UpdateWeeklyBasicScore::dispatch($participant, $season_id, $force);
                $bar->advance();
            }
        });

        $bar->finish();

        $this->info('Complete.');
    }

    private function getSeason($seasonId)
    {
        if ($seasonId == 'latest') {
            return Season::latest()->first();
        }

        return Season::where('id', intval($seasonId))->whereIn('status', ['ready', 'open'])->first();
    }
}
