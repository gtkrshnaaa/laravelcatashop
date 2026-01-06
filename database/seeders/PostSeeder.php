<?php

namespace Database\Seeders;

use App\Models\Post;
use Illuminate\Database\Seeder;

class PostSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $posts = [
            [
                'title' => 'Welcome to LaravelCataShop',
                'slug' => 'welcome-to-laravelcatashop',
                'excerpt' => 'Discover our new e-commerce platform built with Laravel 11. Simple, powerful, and easy to use.',
                'content' => "# Welcome to LaravelCataShop\n\nWe're excited to launch our new e-commerce platform! Built with Laravel 11, our shop offers a seamless shopping experience with:\n\n- Easy product browsing\n- Secure checkout\n- Order tracking\n- Customer reviews\n\nStart shopping today and experience the difference!",
                'is_published' => true,
                'published_at' => now()->subDays(7),
            ],
            [
                'title' => 'New Product Categories Available',
                'slug' => 'new-product-categories-available',
                'excerpt' => 'We\'ve added new categories to help you find exactly what you need. Check out our expanded catalog!',
                'content' => "# New Categories Now Live!\n\nWe're constantly expanding our product range. This month we've added:\n\n## Electronics\nLatest gadgets and accessories\n\n## Fashion\nTrendy clothing and accessories\n\n## Home & Living\nEverything for your home\n\nBrowse our catalog and discover amazing products at great prices!",
                'is_published' => true,
                'published_at' => now()->subDays(5),
            ],
            [
                'title' => 'How to Track Your Orders',
                'slug' => 'how-to-track-your-orders',
                'excerpt' => 'Learn how to easily track your orders and stay updated on delivery status.',
                'content' => "# Order Tracking Made Easy\n\n## Step 1: Login to Your Account\nAccess your customer dashboard\n\n## Step 2: View Orders\nCheck all your order history\n\n## Step 3: Track Status\nSee real-time updates on your order\n\n## Step 4: Contact Support\nNeed help? We're here for you!\n\nFor any questions, don't hesitate to reach out via WhatsApp.",
                'is_published' => true,
                'published_at' => now()->subDays(3),
            ],
            [
                'title' => 'Customer Review Program Launch',
                'slug' => 'customer-review-program-launch',
                'excerpt' => 'Help other shoppers by sharing your experience. Leave reviews and earn rewards!',
                'content' => "# Share Your Experience\n\nYour feedback matters! We've launched our customer review program.\n\n## Benefits of Reviewing:\n- Help other customers make informed decisions\n- Share photos of your purchases\n- Rate products on quality and service\n\nEvery review helps us improve. Thank you for being part of our community!",
                'is_published' => true,
                'published_at' => now()->subDays(1),
            ],
            [
                'title' => 'Upcoming Sales and Promotions',
                'slug' => 'upcoming-sales-and-promotions',
                'excerpt' => 'Don\'t miss our upcoming mega sale! Amazing discounts on selected products.',
                'content' => "# Big Sale Coming Soon!\n\n## What to Expect:\n- Up to 50% off on selected items\n- Special coupon codes for VIP customers\n- Flash deals every hour\n- Free shipping on orders above Rp 150,000\n\n## Save the Date!\nMark your calendars and get ready for the best deals of the year!\n\nStay tuned to our social media for exclusive early access codes.",
                'is_published' => false,
                'published_at' => now()->addDays(5),
            ],
        ];

        foreach ($posts as $post) {
            Post::create($post);
        }
    }
}
