<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */

use App\Human;
use Faker\Generator as Faker;

$factory->define(Human::class, function (Faker $faker) {
    return [
        //
        'patient_id' => $faker->unique()->numberBetween($min=1, $max=100),
        'dni' => $faker->randomNumber(8),
        'surname' => $faker->lastName(),
        'sex' => $faker->randomElement($array = array('F', 'M')),
        'birth_date' => $faker->date($format = 'Y-m-d', $max = 'now'),
        'city' => $faker->city,
        'home_address' => $faker->streetAddress,
    ];
});
