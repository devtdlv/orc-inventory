<?php

namespace Database\Seeders;

use App\Models\Category;
use App\Models\Checkout;
use App\Models\Consumable;
use App\Models\Item;
use App\Models\MaintenanceLog;
use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class DatabaseSeeder extends Seeder
{
    use WithoutModelEvents;

    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // Create admin user
        $admin = User::factory()->create([
            'name' => 'Admin User',
            'email' => 'admin@orcinventory.com',
            'password' => Hash::make('password'),
        ]);

        // Create additional users
        $users = User::factory(5)->create();
        $allUsers = collect([$admin])->merge($users);

        // Create categories with realistic names
        $categories = collect([
            ['name' => 'Power Tools', 'description' => 'Electric and battery-powered tools', 'color' => '#3B82F6'],
            ['name' => 'Hand Tools', 'description' => 'Manual tools and equipment', 'color' => '#10B981'],
            ['name' => 'Fasteners', 'description' => 'Screws, bolts, nails, and hardware', 'color' => '#F59E0B'],
            ['name' => 'Safety Equipment', 'description' => 'Protective gear and safety items', 'color' => '#EF4444'],
            ['name' => 'Consumables', 'description' => 'Items that get used up', 'color' => '#8B5CF6'],
            ['name' => 'Measuring Tools', 'description' => 'Rulers, levels, and measuring devices', 'color' => '#06B6D4'],
            ['name' => 'Automotive', 'description' => 'Car and vehicle related items', 'color' => '#EC4899'],
            ['name' => 'Electrical', 'description' => 'Wires, connectors, and electrical supplies', 'color' => '#84CC16'],
        ])->map(function ($category) {
            return Category::create($category);
        });

        // Create items
        $items = collect();

        // Create some tools
        foreach ($categories->take(4) as $category) {
            $items = $items->merge(
                Item::factory(8)
                    ->tool()
                    ->for($category)
                    ->create()
            );
        }

        // Create some consumables
        foreach ($categories->slice(4) as $category) {
            $items = $items->merge(
                Item::factory(6)
                    ->consumable()
                    ->for($category)
                    ->create()
            );
        }

        // Create some low stock items
        Item::factory(5)
            ->consumable()
            ->lowStock()
            ->for($categories->random())
            ->create();

        // Create maintenance logs
        $maintenanceCount = min(20, $items->count());
        if ($maintenanceCount > 0) {
            foreach ($items->random($maintenanceCount) as $item) {
                MaintenanceLog::factory(rand(1, 3))
                    ->for($item)
                    ->for($allUsers->random())
                    ->create();
            }
        }

        // Create checkouts (some checked out, some checked in)
        $toolItems = $items->where('is_tool', true);
        $toolCount = min(15, $toolItems->count());
        
        if ($toolCount > 0) {
            foreach ($toolItems->random($toolCount) as $item) {
            $user = $allUsers->random();
            $checkedOutBy = $allUsers->random();
            
            $checkout = Checkout::factory()
                ->for($item)
                ->for($user)
                ->for($checkedOutBy, 'checkedOutBy')
                ->create();

                // 60% chance of being checked in
                if (rand(1, 10) <= 6) {
                    $checkout->update([
                        'status' => 'checked_in',
                        'checked_in_at' => now()->subDays(rand(1, 30)),
                        'checked_in_by' => $allUsers->random()->id,
                    ]);
                }
            }
        }

        // Create consumable usage records
        $consumableItems = $items->where('is_consumable', true);
        $consumableCount = min(25, $consumableItems->count());
        
        if ($consumableCount > 0) {
            foreach ($consumableItems->random($consumableCount) as $item) {
                Consumable::factory(rand(1, 4))
                    ->for($item)
                    ->for($allUsers->random())
                    ->create();
            }
        }

        $this->command->info('Database seeded successfully!');
        $this->command->info('Admin login: admin@orcinventory.com / password');
        $this->command->info('Created:');
        $this->command->info('  - ' . User::count() . ' users');
        $this->command->info('  - ' . Category::count() . ' categories');
        $this->command->info('  - ' . Item::count() . ' items');
        $this->command->info('  - ' . MaintenanceLog::count() . ' maintenance logs');
        $this->command->info('  - ' . Checkout::count() . ' checkouts');
        $this->command->info('  - ' . Consumable::count() . ' consumable records');
    }
}
