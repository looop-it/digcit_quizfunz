<?php

namespace App\Console\Commands;

use App\Models\Season;
use App\Models\Participant;
use App\Jobs\UpdateBasicScore;
use Illuminate\Console\Command;

class PanticipantUpdateBasicScore extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'participant:update-basic-score {season?}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Update participants best score and time to basic_scores table for ranking calc';

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
            $seasonId = $this->ask('Which season id do you want to update?', 'latest');
        }

        $season = $this->getSeason($seasonId);

        if (!$season) {
            return $this->error('Season id provided is not valid! Please double confirm!!');
        }
        
        $participants = Participant::get();

        $bar = $this->output->createProgressBar($participants->count());

        $bar->start();
        foreach ($participants as $participant) {
            UpdateBasicScore::dispatch($participant, $season->id);
            $bar->advance();
        }

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
