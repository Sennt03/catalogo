<?php

namespace Database\Factories;

use App\Models\Product;
use App\Models\ProductVariant;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends Factory<ProductVariant>
 */
class ProductVariantFactory extends Factory
{
    public function definition(): array
    {
        return [
            'product_id' => Product::factory(),
            'sku' => fake()->unique()->bothify('SKU-####-??'),
            'name' => null,
            'price' => fake()->randomFloat(2, 1, 500),
            'compare_at_price' => null,
            'stock' => fake()->numberBetween(0, 200),
            'is_active' => true,
            'sort_order' => 0,
        ];
    }

    public function named(string $name): static
    {
        return $this->state(['name' => $name]);
    }

    public function outOfStock(): static
    {
        return $this->state(['stock' => 0]);
    }
}
