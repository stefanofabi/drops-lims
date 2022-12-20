<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

use App\Models\Prescriber;

class PrescriberFactory extends Factory {

    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = Prescriber::class;

    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
	    return [
	        //
	        'name' => $this->faker->name(),
            'last_name' => $this->faker->lastName(),
	        'phone' => $this->faker->randomNumber(8),
	        'email' => $this->faker->safeEmail,
	        'primary_enrollment' => $this->faker->randomNumber(4),
	        'secondary_enrollment' => $this->faker->randomNumber(4),
	    ];
    }
}