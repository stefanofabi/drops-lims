<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

use App\Models\InternalPatient;

class InternalPatientFactory extends Factory {

    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = InternalPatient::class;


    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
		return [
			'name' => $this->faker->name(),
			'last_name' => $this->faker->lastName(),
			'identification_number' => $this->faker->numberBetween(0, 1) ? $this->faker->randomNumber(8) : null,
			'sex' => $this->faker->randomElement($array = array('F', 'M')),
			'birthdate' => $this->faker->numberBetween(0, 1) ? $this->faker->date($format = 'Y-m-d', $max = 'now') : null,
			'city' => $this->faker->numberBetween(0, 1) ? $this->faker->city : null,
			'address' => $this->faker->numberBetween(0, 1) ? $this->faker->streetAddress : null, 
			'phone' => $this->faker->numberBetween(0, 1) ? $this->faker->phoneNumber : null,
			'email' => $this->faker->numberBetween(0, 1) ? $this->faker->safeEmail : null,
			'plan_id' => $this->faker->numberBetween(0, 1) ? $this->faker->randomElement($array = array(1, 2, 3)) : null,
			'affiliate_number' => $this->faker->numberBetween(0, 1) ? $this->faker->randomNumber(8) : null,
			'security_code' => $this->faker->numberBetween(0, 1) ? $this->faker->randomNumber(3) : null,
			'expiration_date' => $this->faker->numberBetween(0, 1) ? $this->faker->date($format = 'Y-m-d', $max = date('Y-m-d', strtotime('+10 years'))) : null,
		];
    }
}