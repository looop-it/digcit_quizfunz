<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Models\Question;

class QuestionUpdate extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'question:update {question?}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Update quetion releated information.';

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct()
    {
        parent::__construct();
    }

    /**
     * Execute the console command.
     *
     * @return mixed
     */
    public function handle()
    {
        $questionId = $this->argument('question');
        
        if ($questionId) {
            $questions = Question::where('id', $questionId)->get();
        } else {
            $questions = Question::all();
        }
        
        foreach ($questions as $question) {
            foreach ($question->paperQuestions as $paperQuestion) {
                try {
                    $paperQuestion->update([
                        'options' => $question->answers()->inRandomOrder()->pluck('correct', 'content')
                    ]);
                } catch (\Exception $exception) {
                    \Log::error("Failed to update options of paper_questions. ID: {$paperQuestion->id}");
                }
            }
        }
    }
}
