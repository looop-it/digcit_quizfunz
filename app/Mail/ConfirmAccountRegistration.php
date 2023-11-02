<?php

namespace App\Mail;

use App\Models\User;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class ConfirmAccountRegistration extends Mailable implements ShouldQueue
{
    use Queueable;
    use SerializesModels;

    public $user;
    public $subject;

    /**
     * Create a new message instance.
     */
    public function __construct(User $user)
    {
        $this->user = $user;
        $this->subject = '立即啟動帳號成為挑戰者 - 國情多角度-校際挑戰賽';
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        return $this->subject($this->subject)
                    ->view('emails.registration.confirm_account_registration')
                    ->with([
                        'name' => $this->user->name,
                        'token' => $this->user->verification_token,
                    ]);
    }
}
