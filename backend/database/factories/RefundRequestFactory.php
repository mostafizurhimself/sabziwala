<?php

namespace Database\Factories;

use App\Models\Order;
use Illuminate\Database\Eloquent\Factories\Factory;
use App\Models\RefundRequest;

class RefundRequestFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = RefundRequest::class;

    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        $order = Order::inRandomOrder()->first();
        return [
            'customer_id' => $order->customerId,
            'order_id'    => $order->id,
            'reason'      => $this->faker->paragraph(5)
        ];
    }
}