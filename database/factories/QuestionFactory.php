<?php

use Faker\Generator as Faker;
use App\Models\Question;
use App\Models\QuestionCategory;
use App\Models\Scope;

$factory->define(Question::class, function (Faker $faker) {
    return [
        'category_id' => QuestionCategory::inRandomOrder()->first()->id,
        'scope_id' => Scope::inRandomOrder()->first()->id,
        'name' => $faker->sentence,
        'description' => $faker->sentence,
        'level' => $faker->randomElement([1, 2, 3])
    ];
});
