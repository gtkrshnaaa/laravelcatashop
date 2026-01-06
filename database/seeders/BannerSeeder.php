<?php

namespace Database\Seeders;

use App\Models\Banner;
use Illuminate\Database\Seeder;

class BannerSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // 1. Electronics Banner
        Banner::create([
            'title' => 'Next-Gen Tech <br> <span class="text-transparent bg-clip-text bg-gradient-to-r from-cyan-400 to-blue-600">Upgrade Your Life</span>',
            'subtitle' => 'Discover the latest gadgets and smart devices driven by innovation.',
            'image' => 'banners/hero_electronics.png',
            'link' => '/catalog?category=electronics',
            'button_text' => 'Shop Electronics',
            'position' => 1,
            'is_active' => true,
        ]);

        // 2. Fashion Banner
        Banner::create([
            'title' => 'Define Your Style <br> <span class="text-transparent bg-clip-text bg-gradient-to-r from-pink-500 to-orange-400">Be Bold & Unique</span>',
            'subtitle' => 'Premium fashion collections that make you stand out from the crowd.',
            'image' => 'banners/hero_fashion.png',
            'link' => '/catalog?category=fashion',
            'button_text' => 'Explore Collection',
            'position' => 2,
            'is_active' => true,
        ]);

        // 3. Lifestyle Banner
        Banner::create([
            'title' => 'Cozy Living <br> <span class="text-transparent bg-clip-text bg-gradient-to-r from-green-400 to-emerald-600">Home Sweet Home</span>',
            'subtitle' => 'Minimalist decor and furniture to transform your space into a sanctuary.',
            'image' => 'banners/hero_lifestyle.png',
            'link' => '/catalog?category=home-decor',
            'button_text' => 'Shop Home Decor',
            'position' => 3,
            'is_active' => true,
        ]);
    }
}
