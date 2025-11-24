<?php

namespace Database\Factories;

use App\Models\Category;
use App\Models\Item;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Item>
 */
class ItemFactory extends Factory
{
    protected $model = Item::class;

    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        $stockLevel = fake()->numberBetween(0, 100);
        $minStockLevel = fake()->numberBetween(5, 20);
        
        return [
            'category_id' => Category::factory(),
            'name' => fake()->words(3, true),
            'description' => fake()->optional()->sentence(),
            'barcode' => 'BC-' . fake()->unique()->numerify('########'),
            'qr_code' => 'ORC-' . strtoupper(fake()->unique()->bothify('??########')),
            'stock_level' => $stockLevel,
            'min_stock_level' => $minStockLevel,
            'location' => fake()->optional()->randomElement(['Shelf A', 'Shelf B', 'Drawer 1', 'Drawer 2', 'Toolbox', 'Garage', 'Workshop']),
            'is_consumable' => fake()->boolean(30),
            'is_tool' => fake()->boolean(70),
        ];
    }

    public function tool(): static
    {
        return $this->state(fn (array $attributes) => [
            'is_tool' => true,
            'is_consumable' => false,
            'stock_level' => 1,
            'min_stock_level' => 0,
        ]);
    }

    public function consumable(): static
    {
        return $this->state(fn (array $attributes) => [
            'is_consumable' => true,
            'is_tool' => false,
        ]);
    }

    public function lowStock(): static
    {
        return $this->state(fn (array $attributes) => [
            'stock_level' => fake()->numberBetween(0, 5),
            'min_stock_level' => fake()->numberBetween(10, 20),
        ]);
    }
}

