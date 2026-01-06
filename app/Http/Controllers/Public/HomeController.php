<?php

namespace App\Http\Controllers\Public;

use App\Http\Controllers\Controller;
use App\Models\Category;
use App\Models\Product;

class HomeController extends Controller
{
    /**
     * Display the homepage.
     */
    public function index()
    {
        $banners = \App\Models\Banner::active()->get();
        
        $featuredCategories = Category::where('is_featured', true)
            ->withCount('products')
            ->get();

        $featuredProducts = Product::where('is_active', true)
            ->with('category')
            ->latest()
            ->take(8)
            ->get();

        // Stats for "Flash Sale" / Scarcity logic
        $weeklyLimit = 50;
        $usedSlots = \App\Models\Transaction::whereBetween('created_at', [now()->startOfWeek(), now()->endOfWeek()])->count();
        $slotsRemaining = max(0, $weeklyLimit - $usedSlots);

        // Service Features (Static for now)
        $serviceFeatures = [
            [
                'title' => 'Fast Delivery',
                'description' => 'Get your orders delivered within 24 hours in Jabodetabek area.',
                'icon' => 'truck', // We'll use SVG or Heroicons in view
                'color' => 'blue'
            ],
            [
                'title' => 'Secure Payment',
                'description' => '100% secure payment with Midtrans. We value your privacy.',
                'icon' => 'shield-check',
                'color' => 'green'
            ],
            [
                'title' => '24/7 Support',
                'description' => 'Our team is ready to help you anytime, anywhere.',
                'icon' => 'chat',
                'color' => 'purple'
            ]
        ];

        return view('public.home.index', compact(
            'banners', 
            'featuredCategories', 
            'featuredProducts', 
            'weeklyLimit', 
            'usedSlots', 
            'slotsRemaining',
            'serviceFeatures'
        ));
    }
}
