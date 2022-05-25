<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use App\Models\Zone;

class ZoneFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = Zone::class;

    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        return [
            'name'      => "Zone " . $this->faker->numberBetween(1, 10),
            'state'     => $this->faker->streetAddress,
            'city'      => $this->faker->city,
            'zipcode'   => $this->faker->postcode,
            'country'   => $this->faker->country,
        ];
    }
}
