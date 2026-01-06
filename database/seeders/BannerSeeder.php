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
        $banners = [
            [
                'title' => 'Welcome to LaravelCataShop',
                'image' => 'banners/welcome.jpg',
                'link' => '/catalog',
                'position' => 1,
                'is_active' => true,
            ],
            [
                'title' => 'Big Sale 2026',
                'image' => 'banners/sale.jpg',
                'link' => '/catalog?category=1',
                'position' => 2,
                'is_active' => true,
            ],
            [
                'title' => 'New Arrivals',
                'image' => 'banners/new-products.jpg',
                'link' => '/catalog',
                'position' => 3,
                'is_active' => true,
            ],
        ];

        foreach ($banners as $banner) {
            Banner::create($banner);
        }
    }
}
