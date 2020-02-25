<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;

use App\Models\School;
use App\Jobs\GenerateSchoolCode;

class SchoolGenCode extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'school:gen-code {school?}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Generate competition code for school';

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
        $schoolId = $this->argument('school');

        if ($schoolId) {
            $schools = School::where('id', intval($schoolId))->get();
        } else {
            $schools = School::whereNull('code')->get();
        }

        foreach ($schools as $school) {
            dispatch(new GenerateSchoolCode($school));
        }
    }
}
