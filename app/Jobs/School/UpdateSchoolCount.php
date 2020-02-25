<?php

namespace App\Jobs\School;

use App\Models\School;
use Illuminate\Bus\Queueable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;

class UpdateSchoolCount implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    public $school;
    public $seasonId;

    /**
     * Create a new job instance.
     *
     * @return void
     */
    public function __construct(School $school, int $seasonId)
    {
        $this->school = $school;
        $this->seasonId = $seasonId;
    }

    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle()
    {
        try {
            $participants = $this->school->basicScores->where('season_id', $this->seasonId)->count();

            $this->school->update([
                'actual_participant' => $participants
            ]);
        } catch (\Exception $exception) {
            \Log::error("Failed to update school's actual_participant. Error: {$exception->getMessage()}");
        }
    }
}
