<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;
use App\Models\SchoolRegistration;

class VerifySchoolRegistration extends Mailable
{
    use Queueable, SerializesModels;

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
        return $this->subject('電郵地址驗證 - 「國安法、基本法通通識」全港中學線上挑戰賽')
                    ->view('emails.registration.verify_school_registration');
    }
}
