<?php

namespace App\Jobs;

use Illuminate\Bus\Queueable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;

use App\Models\Season;
use App\Facades\PaperGenerator;
use Illuminate\Support\Facades\DB;
use App\Models\Paper;

class GeneratePaper implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    public $season;

    /**
     * Create a new job instance.
     *
     * @return void
     */
    public function __construct(Season $season)
    {
        $this->season = $season;
    }

    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle()
    {
        $result = PaperGenerator::setSeason($this->season)->generate();

        DB::beginTransaction();
        
        try {
            $paper = $this->season->papers()->create([
                'status' => 'created',
                'number' => $this->generateRandomNumber(),
                'difficulty' => $result['difficulty']
            ]);

            foreach ($result['questions'] as $question) {
                $paper->questions()->attach($question->id, [
                    'options' => $question->answers()->inRandomOrder()->pluck('correct', 'content')
                ]);
            }
            
            DB::commit();
        } catch (\Exception $exception) {
            DB::rollback();

            \Log::error('Failed to store paper & questions. Error: ' . $exception->getMessage());
        }
    }

    /**
     * Generate unique paper number.
     *
     * @return string
     */
    private function generateRandomNumber() : string
    {
        do {
            $number = now()->format('Ym') . "-" . strtoupper(str_random(8));
        } while (Paper::where('number', $number)->exists());

        return $number;
    }
}
