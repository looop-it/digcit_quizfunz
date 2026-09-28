<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;

use App\Models\School;
use App\Models\Season;
use App\Jobs\School\UpdateSchoolStatistics;

class SchoolUpdateStatistics extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'school:update-statistics';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Update schools actual_participant in a condition of the participant who had one validated paper';

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
        $schools = School::approved()->get();
        $seasons = Season::open()->get();

        $bar = $this->output->createProgressBar($schools->count() * max($seasons->count(), 1));
        $bar->start();

        foreach ($seasons as $season) {
            foreach ($schools as $school) {
                UpdateSchoolStatistics::dispatch($school, $season->id);

                $bar->advance();
            }
        }

        $bar->finish();
    }
}
