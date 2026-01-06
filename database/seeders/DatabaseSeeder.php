<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    use WithoutModelEvents;

    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // Create admin user
        User::factory()->create([
            'name' => 'Admin',
            'email' => 'admin@laravelcatashop.test',
        ]);

        // Seed in dependency order
        $this->call([
            // Core data
            CategorySeeder::class,
            ProductSeeder::class,
            CustomerSeeder::class,
            
            // Feature data
            CouponSeeder::class,
            PostSeeder::class,
            PageSeeder::class,
            BannerSeeder::class,
            
            // Transaction and reviews (depend on products & customers)
            TransactionSeeder::class,
            ReviewSeeder::class,
            TagSeeder::class,
            BannerSeeder::class,
        ]);
    }
}
