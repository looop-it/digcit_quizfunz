<?php

namespace App\Jobs;

use App\Mail\SchoolDailyReport;
use App\Models\SchoolRegistration;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\Mail;

class SendDailyReportToSchool implements ShouldQueue
{
    use Dispatchable;
    use InteractsWithQueue;
    use Queueable;
    use SerializesModels;

    public $schoolRegistration;
    public $season;

    /**
     * Create a new job instance.
     *
     * @return void
     */
    public function __construct(SchoolRegistration $schoolRegistration, int $seasonId)
    {
        $this->schoolRegistration = $schoolRegistration;
        $this->season = $seasonId;
    }

    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle()
    {
        Mail::to($this->schoolRegistration->email)->queue(
            new SchoolDailyReport($this->schoolRegistration->school, $this->season)
        );
    }
}
