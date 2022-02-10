<?php

namespace App\Console\Commands;

use App\Jobs\School\SendSchoolCode;
use App\Models\SchoolRegistration;
use Illuminate\Console\Command;

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
    protected $description = 'Send competition code to registed schools';

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
            $schoolRegistrations = SchoolRegistration::where('id', $schoolId)->get();
        } else {
            $schoolRegistrations = SchoolRegistration::approved()->get();
        }

        foreach ($schoolRegistrations as $r) {
            dispatch(new SendSchoolCode($r));
        }
    }
}
