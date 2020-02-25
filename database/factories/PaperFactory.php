<?php

use Faker\Generator as Faker;
use App\Models\Paper;
use App\Models\Participant;
use App\Models\Season;

$factory->define(Paper::class, function (Faker $faker) {
    return [
        'participant_id' => Participant::inRandomOrder()->first()->id,
        'season_id' => Season::inRandomOrder()->first()->id
    ];
});
