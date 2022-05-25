<?php

namespace Database\Seeders;

use App\Models\Country;
use Illuminate\Database\Seeder;

class CountrySeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $countries = array(
            array('code' => 'BD', 'name' => 'Bangladesh'),
            array('code' => 'PK', 'name' => 'Pakistan'),
            // array('code' => 'US', 'name' => 'United States'),

        );

        foreach ($countries as $country) {
            Country::updateOrCreate(
                ['code' => $country['code']],
                ['name' => $country['name'], 'code' => $country['code']]
            );
        }
    }
}