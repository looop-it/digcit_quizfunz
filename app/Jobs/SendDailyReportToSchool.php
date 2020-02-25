<?php

namespace App\Jobs;

use Illuminate\Bus\Queueable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;

use App\Models\School;
use Illuminate\Support\Facades\Mail;
use App\Mail\SchoolDailyReport;

class SendDailyReportToSchool implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    public $school;
    public $season;

    /**
     * Create a new job instance.
     *
     * @return void
     */
    public function __construct(School $school, int $seasonId)
    {
        $this->school = $school;
        $this->season = $seasonId;
    }

    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle()
    {
        Mail::to($this->school->email)->queue(
            new SchoolDailyReport($this->school, $this->season)
        );
    }
}
