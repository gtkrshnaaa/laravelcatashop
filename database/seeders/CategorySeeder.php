<?php

namespace Database\Seeders;

use App\Models\Category;
use Illuminate\Database\Seeder;

class CategorySeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $categories = [
            [
                'name' => 'Electronics',
                'slug' => 'electronics',
                'description' => 'Gadgets, computers, and electronic devices',
                'is_featured' => true,
            ],
            [
                'name' => 'Fashion',
                'slug' => 'fashion',
                'description' => 'Clothing, shoes, and accessories',
                'is_featured' => true,
            ],
            [
                'name' => 'Books',
                'slug' => 'books',
                'description' => 'Physical and digital books',
                'is_featured' => false,
            ],
            [
                'name' => 'Food & Beverage',
                'slug' => 'food-beverage',
                'description' => 'Snacks, drinks, and food products',
                'is_featured' => false,
            ],
            [
                'name' => 'Home & Living',
                'slug' => 'home-living',
                'description' => 'Furniture, decoration, and home essentials',
                'is_featured' => false,
            ],
        ];

        foreach ($categories as $category) {
            Category::create($category);
        }
    }
}
