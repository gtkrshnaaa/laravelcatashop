<?php

namespace Database\Seeders;

use App\Models\Product;
use App\Models\Tag;
use Illuminate\Database\Seeder;
use Illuminate\Support\Str;

class TagSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // 1. Create Tags
        $tags = [
            'New Arrival',
            'Best Seller',
            'Trending',
            'Limited Edition',
            'Exclusive',
            'Eco-Friendly',
            'Premium',
            'Budget Friendly'
        ];

        foreach ($tags as $tagName) {
            Tag::firstOrCreate(
                ['name' => $tagName],
                ['slug' => Str::slug($tagName)]
            );
        }

        // 2. Attach Tags to Random Products & Scramble Search Counts
        $allTags = Tag::all();
        $products = Product::all();

        foreach ($products as $product) {
            // Attach 0 to 3 random tags
            $randomTags = $allTags->random(rand(0, 3))->pluck('id');
            $product->tags()->sync($randomTags);

            // Scramble search count (0 to 1000)
            $product->update([
                'search_count' => rand(0, 1000)
            ]);
        }
    }
}
