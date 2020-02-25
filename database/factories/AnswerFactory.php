<?php

use Faker\Generator as Faker;
use App\Models\Answer;
use App\Models\Question;

$factory->define(Answer::class, function (Faker $faker) {
    return [
        'question_id' => Question::inRandomOrder()->first()->id,
        'content' => $faker->word,
        'correct' => false
    ];
});
