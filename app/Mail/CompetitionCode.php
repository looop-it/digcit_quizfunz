<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Contracts\Queue\ShouldQueue;
use App\Models\School;

class CompetitionCode extends Mailable
{
    use Queueable, SerializesModels;

    public $school;

    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct(School $school)
    {
        $this->school = $school;
        $this->subject = '大灣區知識爭霸戰－中學賽－學校認證碼';
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        return $this->subject($this->subject)
                    ->view('emails.registration.competition_code');
    }
}
