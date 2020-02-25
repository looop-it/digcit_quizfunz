<?php

use Faker\Generator as Faker;
use App\Models\QuestionCategory;

$factory->define(QuestionCategory::class, function (Faker $faker) {
    return [
        'name' => $faker->city
    ];
});
