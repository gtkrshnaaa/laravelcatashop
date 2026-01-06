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
        $featuredCategories = Category::where('is_featured', true)
            ->withCount('products')
            ->get();

        $featuredProducts = Product::where('is_active', true)
            ->with('category')
            ->latest()
            ->take(8)
            ->get();

        return view('public.home.index', compact('featuredCategories', 'featuredProducts'));
    }
}
