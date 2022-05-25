<?php

namespace Database\Seeders;

use App\Models\Customer;
use App\Models\Transaction;
use Illuminate\Database\Seeder;

class TransactionSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        \App\Models\Transaction::factory(100)->create();
    }
}
