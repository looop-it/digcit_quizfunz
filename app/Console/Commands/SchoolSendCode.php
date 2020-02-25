<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;

use App\Models\School;
use App\Jobs\SendSchoolCode;

class SchoolSendCode extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'school:send-code {school?}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Send competition code to schools';

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
            $schools = School::where('id', $schoolId)->get();
        } else {
            $schools = School::verified()->get();
        }

        foreach ($schools as $school) {
            dispatch(new SendSchoolCode($school));
        }
    }
}
