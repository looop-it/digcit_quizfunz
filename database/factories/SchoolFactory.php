<?php

use Faker\Generator as Faker;
use App\Models\School;

$factory->define(School::class, function (Faker $faker) {
    return [
        'name' => $faker->name . ' School',
        'address' => $faker->address,
        'contact' => $faker->name,
        'email' => $faker->email,
        'phone' => $faker->phoneNumber,
        'fax' => $faker->phoneNumber
    ];
});
