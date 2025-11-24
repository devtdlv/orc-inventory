<?php

namespace Database\Factories;

use App\Models\Item;
use App\Models\MaintenanceLog;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\MaintenanceLog>
 */
class MaintenanceLogFactory extends Factory
{
    protected $model = MaintenanceLog::class;

    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        $types = ['Repair', 'Inspection', 'Cleaning', 'Calibration', 'Lubrication', 'Replacement', 'Service'];
        
        return [
            'item_id' => Item::factory(),
            'user_id' => User::factory(),
            'maintenance_type' => fake()->randomElement($types),
            'notes' => fake()->optional()->sentence(),
            'cost' => fake()->optional(0.7)->randomFloat(2, 10, 500),
            'performed_at' => fake()->dateTimeBetween('-1 year', 'now'),
        ];
    }
}

