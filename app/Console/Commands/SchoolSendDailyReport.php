<?php

namespace App\Console\Commands;

use App\Admin\Models\SchoolRegistration;
use App\Facades\ReportManager;
use App\Jobs\SendDailyReportToSchool;
use App\Models\School;
use App\Models\Season;
use Carbon\Carbon;
use Illuminate\Console\Command;

class SchoolSendDailyReport extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'school:daily-report 
                            {season? : The ID of season}
                            {schoolRegistrationId? : The ID of schoolRegistration}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Send daily report to school.';

    private $sendable;
    private $schoolRegistrations;
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

            foreach ($this->schoolRegistrations as $schoolRegistration) {
                try {
                    $reportManager->setSchool($schoolRegistration->school)->generate();
                } catch (\Exception $exception) {
                    \Log::error("Failed to generate & store daily report of school. schoolRegistration ID: {$schoolRegistration->id}. Error: {$exception->getMessage()}");

                    return;
                }

                dispatch(new SendDailyReportToSchool($schoolRegistration, $this->season->id));
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
        $schoolRegistrationId = $this->argument('schoolRegistrationId');

        if ($schoolRegistrationId) {
            $schoolRegistrations = SchoolRegistration::where('id', $schoolRegistrationId)->get();
        } else {
            // $schools = School::approved()->whereHas('students')->get();
            $schoolRegistrations = SchoolRegistration::approved()->get();
        }

        if (count($schoolRegistrations) > 0) {
            $this->schoolRegistrations = $schoolRegistrations;

            return;
        }

        exit('No school available for sending report');
    }

    /**
     * Check whether season has been closed within 24 hours.
     *
     * @param datetime $endTime
     */
    private function isSendable($endTime): bool
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
