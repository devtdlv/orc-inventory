<?php

namespace Database\Factories;

use App\Models\Checkout;
use App\Models\Item;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Checkout>
 */
class CheckoutFactory extends Factory
{
    protected $model = Checkout::class;

    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        $checkedOutAt = fake()->dateTimeBetween('-3 months', 'now');
        $isCheckedIn = fake()->boolean(60);
        $checkedOutBy = User::factory();
        
        return [
            'item_id' => Item::factory(),
            'user_id' => User::factory(),
            'checked_out_by' => $checkedOutBy,
            'checked_out_at' => $checkedOutAt,
            'checked_in_at' => $isCheckedIn ? fake()->dateTimeBetween($checkedOutAt, 'now') : null,
            'checked_in_by' => $isCheckedIn ? User::factory() : null,
            'notes' => fake()->optional()->sentence(),
            'status' => $isCheckedIn ? 'checked_in' : 'checked_out',
        ];
    }

    public function checkedOut(): static
    {
        return $this->state(fn (array $attributes) => [
            'status' => 'checked_out',
            'checked_in_at' => null,
            'checked_in_by' => null,
        ]);
    }

    public function checkedIn(): static
    {
        return $this->state(function (array $attributes) {
            $checkedOutAt = $attributes['checked_out_at'] ?? fake()->dateTimeBetween('-1 month', 'now');
            
            return [
                'status' => 'checked_in',
                'checked_in_at' => fake()->dateTimeBetween($checkedOutAt, 'now'),
                'checked_in_by' => User::factory(),
            ];
        });
    }
}

