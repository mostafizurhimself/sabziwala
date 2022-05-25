<?php

namespace Database\Factories;

use App\Models\Product;
use App\Models\OrderItem;
use Illuminate\Database\Eloquent\Factories\Factory;

class OrderItemFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = OrderItem::class;

    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        $product = Product::inRandomOrder()->first();
        return [
            'product_id' => $product->id,
            'quantity'   => $this->faker->numberBetween(1, 10),
            'rate'       => $product->salePrice,
            'unit_id'    => $product->unitId,
            'amount'     => function($attributes){
                return $attributes['quantity'] * $attributes['rate'];
            }
        ];
    }
}
