<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */

use App\Industrial;
use Faker\Generator as Faker;

$factory->define(Industrial::class, function (Faker $faker) {
	return [
        //
		'patient_id' => $faker->unique()->numberBetween($min=201, $max=300),
		'business_name' => $faker->name(),
		'cuit' => $faker->randomNumber(8),
		'tax_condition' => $faker->randomElement($array = array('Exento', 'Monotributo', 'Responsable inscripto')),   
		'fiscal_address' => $faker->streetAddress,
		'city' => $faker->city,
		'start_activity' => $faker->date($format = 'Y-m-d', $max = 'now'),
	];
});
