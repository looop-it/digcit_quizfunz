<?php

use Faker\Generator as Faker;
use App\Models\Scope;

$factory->define(Scope::class, function (Faker $faker) {
    return [
        'name' => $faker->word
    ];
});
