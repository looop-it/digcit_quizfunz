<?php

use Faker\Generator as Faker;
use App\Models\Participant;
use App\Models\School;

$factory->define(Participant::class, function (Faker $faker) {
    return [
        // 'user_id' => App\User::inRandomOrder()->first()->id,
        'school_id' => function () {
            $isStudent = (rand(1, 100) % 2) == 0;

            if ($isStudent) {
                return School::inRandomOrder()->first()->id;
            }

            return null;
        },
        'name' => $faker->name,
        'grade' => $faker->randomElement(['1', '2', '3', '4', '5', '6']),
        'class' => function ($participant) use ($faker) {
            return $participant['grade'] . $faker->randomElement(['A', 'B', 'C', 'D', 'E']);
        }
    ];
});
