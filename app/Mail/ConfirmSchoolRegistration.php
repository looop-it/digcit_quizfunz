<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;
use App\Models\SchoolRegistration;

class ConfirmSchoolRegistration extends Mailable
{
    use Queueable, SerializesModels;

    public $registration;
    public $subject;
    public $token;

    /**
     * Create a new message instance.
     */
    public function __construct(SchoolRegistration $registration)
    {
        $this->subject = '登記已核實 - 「國安法、基本法通通識」全港中學網上挑戰賽';
        $this->registration = $registration;
        
        $this->token = encrypt(json_encode([
            'email' => $registration->email,
            'token' => $registration->school->code
        ]));
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        return $this->subject($this->subject)
                    ->view('emails.registration.confirm_school_registration');
    }
}
