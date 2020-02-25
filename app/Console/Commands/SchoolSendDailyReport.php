<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Models\School;
use App\Jobs\SendDailyReportToSchool;
use App\Facades\ReportManager;
use Carbon\Carbon;
use App\Models\Season;

class SchoolSendDailyReport extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'school:daily-report 
                            {season? : The ID of season}
                            {school? : The ID of school}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Send daily report to school.';

    private $sendable;
    private $schools;
    private $season;

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
        $this->setSeason();
        $this->setSchool();

        if ($this->sendable) {
            $reportManager = ReportManager::setSeason($this->season->id);

            foreach ($this->schools as $school) {
                try {
                    $reportManager->setSchool($school)->generate();
                } catch (\Exception $exception) {
                    \Log::error("Failed to generate & store daily report of school. School ID: {$school->id}. Error: {$exception->getMessage()}");

                    return;
                }

                dispatch(new SendDailyReportToSchool($school, $this->season->id));
            }
        }
    }

    private function setSeason()
    {
        $seasonId = $this->argument('season');

        if ($seasonId) {
            $season = Season::find(intval($seasonId));
        } else {
            $season = Season::whereIn('status', ['open', 'closed'])->latest()->first();
        }

        if ($season) {
            $this->season = $season;
            $this->sendable = $seasonId ? true : $this->isSendable($season->end_at);

            return;
        }

        exit('No season available for sending report');
    }

    private function setSchool()
    {
        $schoolId = $this->argument('school');

        if ($schoolId) {
            $schools = School::where('id', $schoolId)->get();
        } else {
            // $schools = School::approved()->whereHas('students')->get();
            $schools = School::approved()->get();
        }

        if (count($schools) > 0) {
            $this->schools = $schools;

            return;
        }

        exit('No school available for sending report');
    }

    /**
     * Check whether season has been closed within 24 hours.
     *
     * @param datetime $endTime
     * @return boolean
     */
    private function isSendable($endTime) : bool
    {
        if (Carbon::parse($endTime)->greaterThanOrEqualTo(now())) {
            return true;
        }

        if (Carbon::parse($endTime)->diffInHours(now()) <= 24) {
            return true;
        }

        return false;
    }
}
