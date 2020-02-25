<?php

use Faker\Generator as Faker;
use Carbon\Carbon;
use App\Models\Season;

$factory->define(Season::class, function (Faker $faker) {
    return [
        'name' => $faker->lexify('?????? ?????? 比賽'),
        'start_at' => now(),
        'end_at' => function ($season) {
            return Carbon::parse($season['start_at'])->addDays(30);
        }
    ];
});
