<?php

namespace App\Mail;

use App\Models\SchoolRegistration;
use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class VerifySchoolRegistration extends Mailable
{
    use Queueable;
    use SerializesModels;

    /**
     * Create a new message instance.
     */
    public $registration;

    public function __construct(SchoolRegistration $registration)
    {
        $this->registration = $registration;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        return $this->subject('電郵地址驗證 - 「歷史在線」挑戰賽2.0')
                    ->view('emails.registration.verify_school_registration');
    }
}
