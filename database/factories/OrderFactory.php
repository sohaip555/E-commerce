<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Str;
use App\Models\Order;
use App\Models\User;

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
     */
    public function definition(): array
    {
        return [
            'grand_total' => fake()->randomFloat(2, 0, 99999999.99),
            'payment_method' => fake()->word(),
            'payment_status' => fake()->word(),
            'status' => fake()->randomElement(["new","processing","shipped","delivered","cancelled"]),
            'currency' => fake()->word(),
            'shipping_amount' => fake()->randomFloat(2, 0, 99999999.99),
            'shipping_method' => fake()->word(),
            'notes' => fake()->text(),
            'created_at' => fake()->dateTime(),
            'updated_at' => fake()->dateTime(),
            'user_id' => User::factory(),
        ];
    }
}
