<?php

namespace App\Jobs;

use Illuminate\Bus\Queueable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use App\Models\School;
use Illuminate\Support\Facades\DB;

class GenerateSchoolCode implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    public $school;

    /**
     * Create a new job instance.
     *
     * @return void
     */
    public function __construct(School $school)
    {
        $this->school = $school;
    }

    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle()
    {
        try {
            do {
                $code = $this->generateCode();
            } while (School::where('code', $code)->exists());

            DB::transaction(function () use ($code) {
                $this->school->update([
                    'code' => $code
                ]);
            }, 5);

            dispatch(new SendSchoolCode($this->school));
        } catch (\Exception $exception) {
            \Log::error("Failed to update code for school. Error: {$exception->getMessage()}");
        }
    }

    private function generateCode()
    {
        $letters = "ABCDEFGHJKLMNPQRSTUVWXYZ";
        $numbers = rand(1000, 9999);

        return $letters[rand(0, 23)].$letters[rand(0, 23)].$numbers;
    }
}
