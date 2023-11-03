<?php

namespace App\Mail;

use App\Models\SchoolRegistration;
use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class ConfirmSchoolRegistration extends Mailable
{
    use Queueable;
    use SerializesModels;

    public $registration;
    public $subject;
    public $token;

    /**
     * Create a new message instance.
     */
    public function __construct(SchoolRegistration $registration)
    {
        $this->subject = '登記已核實 - 家國公民智多 FUN 全港中學生知識競賽';
        $this->registration = $registration;

        $this->token = encrypt(json_encode([
            'email' => $registration->email,
            'token' => $registration->school->code,
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
