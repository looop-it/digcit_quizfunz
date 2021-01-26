<?php

namespace App\Jobs\School;

use App\Models\School;
use App\Models\SchoolStatistics;
use Illuminate\Bus\Queueable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;

class UpdateSchoolStatistics implements ShouldQueue
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
            $this->school->load(['students', 'basicScores' => function ($query) {
                $query->where('season_id', $this->seasonId);
            }]);

            $students = $this->school->students->count();
            $bestScores = $this->school->basicScores->where('season_id', $this->seasonId);

            SchoolStatistics::updateOrCreate([
                'school_id' => $this->school->id,
                'season_id' => $this->seasonId
            ], [
                'students' => $students,
                'participants' => $bestScores->count(),
                'scores' => $bestScores->sum('score'),
                'seconds' => $bestScores->sum('seconds_used')
            ]);
        } catch (\Exception $exception) {
            \Log::error("Failed to update school's actual_participant. Error: {$exception->getMessage()}");
        }
    }
}
