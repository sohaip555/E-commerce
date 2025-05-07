<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Str;
use App\Models\Brand;
use App\Models\Category;
use App\Models\Product;

class ProductFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = Product::class;

    /**
     * Define the model's default state.
     */
    public function definition(): array
    {
        return [
            'name' => fake()->name(),
            'slug' => fake()->slug(),
            'images' => json_encode([
                fake()->imageUrl(),
                fake()->imageUrl(),
                fake()->imageUrl(),
            ]),
            'description' => fake()->text(),
            'price' => fake()->randomFloat(2, 150.99, 99999.99),
            'is_active' => fake()->boolean(),
            'is_feature' => fake()->boolean(),
            'in_stock' => fake()->boolean(),
            'on_sale' => fake()->boolean(),
            'created_at' => fake()->dateTime(),
            'updated_at' => fake()->dateTime(),
            'category_id' => Category::factory(),
            'brand_id' => Brand::factory(),
        ];
    }
}
