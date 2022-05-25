<?php

namespace Database\Factories;

use App\Models\Zone;
use App\Models\Rider;
use Illuminate\Database\Eloquent\Factories\Factory;

class RiderFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = Rider::class;

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
            'password' => bcrypt(111111),
        ];
    }

    /**
     * Configure the model factory.
     *
     * @return $this
     */
    public function configure()
    {
        return $this->afterMaking(function (Rider $rider) {
            // Do something before model is inserted into database
        })->afterCreating(function (Rider $rider) {
            $rider->addMediaFromUrl(asset('images/riders/' . $this->faker->numberBetween(1, 7) . '.png'))->toMediaCollection('profile-photo');
        });
    }
}
