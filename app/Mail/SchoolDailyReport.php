<?php

namespace App\Mail;

use App\Facades\ReportManager;
use App\Models\SchoolRegistration;
use App\Models\SchoolStatistics;
use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class SchoolDailyReport extends Mailable
{
    use Queueable;
    use SerializesModels;

    public $schoolRegistration;
    public $season;
    public $subject;
    public $schoolStatistics;

    /**
     * Create a new message instance.
     */
    public function __construct(SchoolRegistration $schoolRegistration, int $seasonId)
    {
        $this->schoolRegistration = $schoolRegistration;
        $this->season = $seasonId;
        $this->subject = '國家安全通通識-校際挑戰賽 —每日學生作賽報告';
        $this->schoolStatistics = SchoolStatistics::where('season_id', $this->season)->where('school_id', $this->schoolRegistration->school_id)->first();
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        $date = now()->format('Y_m_d');

        return $this->view('emails.report.school_daily_report')
                    ->attachData(
                        ReportManager::setSeason($this->season)->setSchool($this->schoolRegistration->school)->setDate($date)->get(),
                        "daily_report_{$date}.xlsx"
                    );
    }
}
