<?php

namespace App\Jobs\Registration;

use Illuminate\Bus\Queueable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;

use App\Models\SchoolRegistration;
use Illuminate\Support\Facades\Mail;
use App\Mail\ConfirmSchoolRegistration;

class SendSchoolRegistrationConfirmEmail implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    public $registration;

    /**
     * Create a new job instance.
     *
     * @return void
     */
    public function __construct(SchoolRegistration $registration)
    {
        $this->registration = $registration;
    }

    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle()
    {
        Mail::to($this->registration->email)->send(
            new ConfirmSchoolRegistration($this->registration)
        );
    }
}
