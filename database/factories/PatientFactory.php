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

			        'owner' => $this->faker->name().' '.$this->faker->lastName(),
			        'identification_number' => $this->faker->randomNumber(8),
			        'phone' => $this->faker->phoneNumber,
					'email' => $this->faker->safeEmail,
					
			        'type' => $type,
			    ];

			    break;
			}

			case 'human': {
				$array = [
			        //
			        'full_name' => $this->faker->lastName()." ". $this->faker->name(),
			        'identification_number' => $this->faker->randomNumber(8),
			        'sex' => $this->faker->randomElement($array = array('F', 'M')),
			        'birth_date' => $this->faker->date($format = 'Y-m-d', $max = 'now'),
			        'city' => $this->faker->city,
			        'address' => $this->faker->streetAddress, 
					'phone' => $this->faker->phoneNumber,
					'email' => $this->faker->safeEmail,
			        
			        'type' => $type,
			    ];

			    break;
			} 

			case 'industrial': {
				$array = [
			        //
			        'full_name' => $this->faker->lastName()." ". $this->faker->name(),
			        'identification_number' => $this->faker->randomNumber(8),
			        'city' => $this->faker->city,
			        'address' => $this->faker->streetAddress, 
					'phone' => $this->faker->phoneNumber,
					'email' => $this->faker->safeEmail,					

			        // for industrials
			        'business_name' => $this->faker->company,
					'tax_condition_id' => $this->faker->randomElement(array(1,2,3,4)),   
					'start_activity' => $this->faker->date($format = 'Y-m-d', $max = 'now'),

			        'type' => $type,
			    ];

			    break;
			}
		}

		return $array;
    }
}