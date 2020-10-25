<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

use App\Models\Patient;

class PatientFactory extends Factory {

    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = Patient::class;


    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {

		$type = $this->faker->randomElement(array('animal', 'human', 'industrial'));

		switch ($type) {
			case 'animal': {
			    $array = [
			        //
			        'full_name' => $this->faker->lastName().' '. $this->faker->name(),
			        'sex' => $this->faker->randomElement($array = array('F', 'M')),
			        'birth_date' => $this->faker->date($format = 'Y-m-d', $max = 'now'),
			        'city' => $this->faker->city,
			        'address' => $this->faker->streetAddress, 

			        // for animals
			        'owner' => $this->faker->name().' '.$this->faker->lastName(),
			        'key' => $this->faker->randomNumber(8),
			        
			        'type' => $type,
			    ];

			    break;
			}

			case 'human': {
				$array = [
			        //
			        'full_name' => $this->faker->lastName()." ". $this->faker->name(),
			        'key' => $this->faker->randomNumber(8),
			        'sex' => $this->faker->randomElement($array = array('F', 'M')),
			        'birth_date' => $this->faker->date($format = 'Y-m-d', $max = 'now'),
			        'city' => $this->faker->city,
			        'address' => $this->faker->streetAddress, 
			        
			        'type' => $type,
			    ];

			    break;
			} 

			case 'industrial': {
				$array = [
			        //
			        'full_name' => $this->faker->lastName()." ". $this->faker->name(),
			        'key' => $this->faker->randomNumber(8),
			        'sex' => $this->faker->randomElement($array = array('F', 'M')),
			        'birth_date' => $this->faker->date($format = 'Y-m-d', $max = 'now'),
			        'city' => $this->faker->city,
			        'address' => $this->faker->streetAddress, 

			        // for industrials
			        'business_name' => $this->faker->name(),
					'tax_condition' => $this->faker->randomElement(array('Exempt', 'Monotax', 'Registered Responsible')),   
					'start_activity' => $this->faker->date($format = 'Y-m-d', $max = 'now'),

			        'type' => $type,
			    ];

			    break;
			}
		}

		return $array;
    }
}