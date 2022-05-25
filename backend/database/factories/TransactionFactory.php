<?php

namespace Database\Factories;

use App\Enums\PaymentMethod;
use App\Models\Order;
use App\Models\Customer;
use App\Models\Transaction;
use Illuminate\Database\Eloquent\Factories\Factory;

class TransactionFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = Transaction::class;

    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        return [
            'customer_id' => $this->faker->randomElement(Customer::pluck('id')->toArray()),
            'order_id'    => $this->faker->randomElement(Order::pluck('id')->toArray()),
            'amount'      => $this->faker->numberBetween(1, 100) * 5,
            'method'      =>PaymentMethod::WALLET(),
            'description' => $this->faker->sentence()
        ];
    }
}
