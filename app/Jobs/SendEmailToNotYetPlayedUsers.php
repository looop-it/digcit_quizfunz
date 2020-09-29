<?php

namespace App\Jobs;

use App\Mail\InvitePlayingGame;
use App\Models\User;
use Illuminate\Bus\Queueable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Support\Facades\Mail;

class SendEmailToNotYetPlayedUsers implements ShouldQueue
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
        User::where('source', 'quizfunz')
            ->chunk(500, function ($users) {
                foreach ($users as $user) {
                    if ($user->papers->count() == 0) {
                        Mail::to($user->email)->queue(new InvitePlayingGame());
                    }
                }
                
                sleep(5);
            });
    }
}
