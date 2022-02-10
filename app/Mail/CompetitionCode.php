<?php

namespace App\Mail;

use App\Models\SchoolRegistration;
use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class CompetitionCode extends Mailable
{
    use Queueable;
    use SerializesModels;

    public $r;

    /**
     * Create a new message instance.
     */
    public function __construct(SchoolRegistration $r)
    {
        $this->r = $r;
        $this->subject = '「國家安全教育通通識」-「校際晉級賽」－學校認證碼';
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
