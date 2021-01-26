<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;

use App\Models\School;
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
        $seasonId = season()->id;

        $bar = $this->output->createProgressBar($schools->count());
        $bar->start();

        foreach ($schools as $school) {
            UpdateSchoolStatistics::dispatch($school, $seasonId);

            $bar->advance();
        }

        $bar->finish();
    }
}
