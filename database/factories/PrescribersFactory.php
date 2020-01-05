<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */

use App\Prescriber;
use Faker\Generator as Faker;

$factory->define(Prescriber::class, function (Faker $faker) {
    return [
        //
        'name' => $faker->name(),
        'last_name' => $faker->lastName(),
        'phone' => $faker->randomNumber(8),
        'email' => $faker->safeEmail,
        'provincial_enrollment' => $faker->randomNumber(4),
        'national_enrollment' => $faker->randomNumber(4),
    ];
});
