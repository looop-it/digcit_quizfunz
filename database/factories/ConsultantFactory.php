<?php

use Faker\Generator as Faker;

use App\Models\Consultant;

$factory->define(Consultant::class, function (Faker $faker) {
    return [
        'name' => $faker->name,
        'image' => $faker->imageUrl(),
        'url' => $faker->url,
        'enabled' => $faker->boolean
    ];
});
