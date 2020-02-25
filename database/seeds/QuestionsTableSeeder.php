<?php

use Illuminate\Database\Seeder;
use App\Models\QuestionCategory;
use App\Models\Question;
use App\Models\Answer;

class QuestionsTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        QuestionCategory::all()->each(function ($category) {
            factory(Question::class, 10)->create([
                'category_id' => $category->id
            ])->each(function ($question) {
                // Insert 4 answers
                $question->answers()->saveMany(factory(Answer::class, 4)->make());

                // Mark one random answer to correct
                $question->answers()
                         ->inRandomOrder()
                         ->first()
                         ->update([
                             'correct' => true
                         ]);
            });
        });
    }
}
