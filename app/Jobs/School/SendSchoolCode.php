<?php

namespace App\Jobs\School;

use App\Mail\CompetitionCode;
use App\Models\SchoolRegistration;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\Mail;

class SendSchoolCode implements ShouldQueue
{
    use Dispatchable;
    use InteractsWithQueue;
    use Queueable;
    use SerializesModels;

    public $r;

    /**
     * Create a new job instance.
     *
     * @return void
     */
    public function __construct(SchoolRegistration $r)
    {
        $this->r = $r;
    }

    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle()
    {
        Mail::to($this->r->email)->queue(
            new CompetitionCode($this->r)
        );
    }
}
