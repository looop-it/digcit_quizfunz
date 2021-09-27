<?php

namespace App\Jobs;

use App\Mail\InviteRegistration;
use App\Models\User;
use Illuminate\Bus\Queueable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Support\Facades\Mail;

class SendEmailToBAQuizUser implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    /**
     * Create a new job instance.
     *
     * @return void
     */
    public function __construct()
    {
        //
    }

    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle()
    {
        User::where('verified', true)
            ->chunk(500, function ($users) {
                foreach ($users as $user) {
                    Mail::to($user->email)->queue(new InviteRegistration());
                }

                sleep(5);
            });
    }
}
