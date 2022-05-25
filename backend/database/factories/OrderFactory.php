<?php

namespace Database\Factories;

use App\Models\Order;
use App\Models\Customer;
use App\Enums\AddressType;
use App\Enums\OrderStatus;
use App\Enums\PaymentMethod;
use App\Models\Rider;
use App\Models\Zone;
use Illuminate\Database\Eloquent\Factories\Factory;

class OrderFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = Order::class;

    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        do {
            $zondId = $this->faker->randomElement(Zone::pluck('id')->toArray());
        } while (!$rider = Rider::where('zone_id', $zondId)->first());

        return [
            'customer_id' => $this->faker->randomElement(Customer::pluck('id')->toArray()),
            'zone_id' => $zondId,
            'note' => $this->faker->sentence(),
            'payment_method' => PaymentMethod::COD(),
            'rider_id' => $rider->id,
            'status' => OrderStatus::SHIPPED(),
        ];
    }

    /**
     * Configure the model factory.
     *
     * @return $this
     */
    public function configure()
    {
        return $this->afterMaking(function (Order $order) {
            // Do something before model is inserted into database
        })->afterCreating(function (Order $order) {
            // Create billing address
            $order->address()->create([
                'type'      => AddressType::BILLING_ADDRESS(),
                'street'    => $this->faker->streetAddress,
                'city'      => $this->faker->city,
                'zipcode'   => $this->faker->postcode,
                'country'   => $this->faker->country,
            ]);

            // Create shipping address
            $order->address()->create([
                'type'      => AddressType::SHIPPING_ADDRESS(),
                'street'    => $this->faker->streetAddress,
                'city'      => $this->faker->city,
                'zipcode'   => $this->faker->postcode,
                'country'   => $this->faker->country,
            ]);
        });
    }
}
