<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Contracts\Queue\ShouldQueue;
use App\Models\School;

class ConfirmSchoolRegistration extends Mailable
{
    use Queueable, SerializesModels;

    /**
     * Create a new message instance.
     *
     * @return void
     */

    public $school;

    public function __construct(School $school)
    {
        $this->school = $school;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        return $this->subject('「大灣區知識爭霸戰－中學賽」- 參賽資格已確認，密切留意23/1「座談暨簡介會」安排')
                    ->view('emails.registration.confirm_school_registration');
    }
}
