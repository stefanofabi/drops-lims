<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */

use App\Animal;
use Faker\Generator as Faker;

$factory->define(Animal::class, function (Faker $faker) {
	return [
        //
		'patient_id' => $faker->unique()->numberBetween($min=101, $max=200),
		'owner' => $faker->name()." ".$faker->lastName(),
		'sex' => $faker->randomElement($array = array('F', 'M')),   
		'home_address' => $faker->streetAddress,
		'city' => $faker->city,
		'birth_date' => $faker->date($format = 'Y-m-d', $max = 'now'),
	];
});
