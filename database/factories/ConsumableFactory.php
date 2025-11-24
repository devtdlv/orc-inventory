<?php

namespace Database\Factories;

use App\Models\Consumable;
use App\Models\Item;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Consumable>
 */
class ConsumableFactory extends Factory
{
    protected $model = Consumable::class;

    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'item_id' => Item::factory(),
            'user_id' => User::factory(),
            'quantity_used' => fake()->numberBetween(1, 10),
            'notes' => fake()->optional()->sentence(),
            'used_at' => fake()->dateTimeBetween('-6 months', 'now'),
        ];
    }
}

