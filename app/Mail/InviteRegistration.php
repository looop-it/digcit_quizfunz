<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class InviteRegistration extends Mailable
{
    use Queueable;
    use SerializesModels;

    public $subject;

    /**
     * Create a new message instance.
     */
    public function __construct()
    {
        $this->subject = '立即報名參與「歷史在線」挑戰賽2.0';
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        return $this->subject($this->subject)
                    ->view('emails.registration.invitation');
    }
}
