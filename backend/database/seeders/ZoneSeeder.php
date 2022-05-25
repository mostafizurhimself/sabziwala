<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Zone;
use Faker\Factory;
class ZoneSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        // \App\Models\Zone::factory(30)->create();
        $faker = Factory::create();
        for ($i = 0; $i < 10; $i++) {
            Zone::create([
                'name'      => "Zone " . $i,
                'state'     => $faker->streetAddress,
                'city'      => $faker->city,
                'zipcode'   => $faker->postcode,
                'country'   => $faker->country,
            ]);
        }
    }
}
