<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class InvitePlayingGame extends Mailable
{
    use Queueable;
    use SerializesModels;

    public $subject;

    /**
     * Create a new message instance.
     */
    public function __construct()
    {
        $this->subject = '立即參加 國家安全通通識-校際挑戰賽';
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        return $this->subject($this->subject)
                    ->view('emails.invite_playing_game');
    }
}
