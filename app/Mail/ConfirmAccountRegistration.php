<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Contracts\Queue\ShouldQueue;
use App\Models\User;

class ConfirmAccountRegistration extends Mailable
{
    use Queueable, SerializesModels;

    public $user;
    public $subject;

    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct(User $user)
    {
        $this->user = $user;
        $this->subject = '立即啟動帳號成為「大灣區知識爭霸戰－中學賽」挑戰者';
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        return $this->subject($this->subject)
                    ->view('emails.registration.confirm_account_registration');
    }
}
