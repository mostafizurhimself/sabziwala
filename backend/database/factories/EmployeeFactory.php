<?php

namespace Database\Factories;

use App\Models\Zone;
use App\Models\Employee;
use Illuminate\Database\Eloquent\Factories\Factory;

class EmployeeFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = Employee::class;

    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        return [
            'zone_id' => $this->faker->randomElement(Zone::pluck('id')->toArray()),
            'first_name' => $this->faker->firstName,
            'last_name' => $this->faker->lastName,
            'email' => $this->faker->safeEmail,
            'phone' => $this->faker->phoneNumber,
            'father_name' => $this->faker->Name,
            'mother_name' => $this->faker->Name,
            'gender' => $this->faker->randomElement(['male', 'female']),
            'marital_status' => $this->faker->randomElement(['Married', 'Unmarried']),
            'blood_group' => $this->faker->randomElement(['A+', 'B+', 'A-', 'B-']),
            'designation' => $this->faker->jobTitle,
            'joining_date' => $this->faker-> DateTime,
            'resign_date' => $this->faker-> DateTime,
            'salary' => $this->faker-> numberBetween(10000, 50000),
            'resign_date' => $this->faker-> DateTime,
        ];
    }

     /**
     * Configure the model factory.
     *
     * @return $this
     */
    public function configure()
    {
        return $this->afterMaking(function (Employee $employee) {
            //
        })->afterCreating(function (Employee $employee) {
            $employee->addMediaFromUrl(asset('images/riders/' . $this->faker->numberBetween(1, 7) . '.png'))->toMediaCollection('profile-photo');
        });
    }
}
