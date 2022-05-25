<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

class RefundRequestSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        \App\Models\RefundRequest::factory(10)->create();
    }
}