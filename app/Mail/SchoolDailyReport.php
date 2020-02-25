<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Contracts\Queue\ShouldQueue;
use App\Models\School;
use Illuminate\Support\Facades\Storage;
use App\Facades\ReportManager;

class SchoolDailyReport extends Mailable
{
    use Queueable, SerializesModels;

    public $school;
    public $season;
    public $subject;

    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct(School $school, int $seasonId)
    {
        $this->school = $school;
        $this->season = $seasonId;
        $this->subject = '大灣區知識爭霸戰—中學賽—每日學生作賽報告';
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
                        ReportManager::setSeason($this->season)->setSchool($this->school)->setDate($date)->get(),
                        "daily_report_{$date}.xlsx"
                    );
    }
}
