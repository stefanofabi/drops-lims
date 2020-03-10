<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */

use App\Patient;
use Faker\Generator as Faker;

$factory->define(Patient::class, function (Faker $faker) {
    return [
        //
        'full_name' => $faker->lastName()." ". $faker->name(),
        'key' => $faker->randomNumber(8),
        'sex' => $faker->randomElement($array = array('F', 'M')),
        'birth_date' => $faker->date($format = 'Y-m-d', $max = 'now'),
        'city' => $faker->city,
        'address' => $faker->streetAddress, 

        // for animals
        'owner' => $faker->name()." ".$faker->lastName(),

        // for industrials
        'business_name' => $faker->name(),
		'tax_condition' => $faker->randomElement(array('Exempt', 'Monotax', 'Registered Responsible')),   
		'start_activity' => $faker->date($format = 'Y-m-d', $max = 'now'),

        'type' => $faker->randomElement(array('animal', 'human', 'industrial')),
    ];
});
