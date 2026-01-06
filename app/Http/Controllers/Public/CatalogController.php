<?php

namespace App\Http\Controllers\Public;

use App\Http\Controllers\Controller;
use App\Models\Category;
use App\Models\Product;
use Illuminate\Http\Request;

class CatalogController extends Controller
{
    /**
     * Display a listing of products.
     */
    public function index(Request $request)
    {
        $query = Product::where('is_active', true)
            ->with(['category', 'tags']);

        // Filter by category
        if ($request->filled('category')) {
            $query->where('category_id', $request->category);
        }

        // Search by name and increment search count
        if ($request->filled('search')) {
            $searchTerm = $request->search;
            $query->where('name', 'like', '%' . $searchTerm . '%');
            
            // Increment search count for exact matches or highly relevant results (simplified logic)
            // In a real app, this might be async or queued
            if (strlen($searchTerm) > 3) {
                 Product::where('name', 'like', '%' . $searchTerm . '%')->increment('search_count');
            }
        }

        // Filter by Price Range
        if ($request->filled('min_price')) {
            $query->where('price', '>=', $request->min_price);
        }
        if ($request->filled('max_price')) {
            $query->where('price', '<=', $request->max_price);
        }

        // Filter by Tags
        if ($request->filled('tags')) {
            $tags = is_array($request->tags) ? $request->tags : explode(',', $request->tags);
            $query->whereHas('tags', function ($q) use ($tags) {
                $q->whereIn('slug', $tags);
            });
        }

        // Sorting
        switch ($request->sort) {
            case 'price_asc':
                $query->orderBy('price', 'asc');
                break;
            case 'price_desc':
                $query->orderBy('price', 'desc');
                break;
            case 'popular':
                $query->orderBy('search_count', 'desc');
                break;
            default:
                $query->latest();
                break;
        }

        // Filter by stock availability
        $query->inStock();

        $products = $query->paginate(12)->withQueryString();
        $categories = Category::withCount('products')->get();
        $tags = \App\Models\Tag::all(); // Fetch all tags for the filter sidebar

        return view('public.catalog.index', compact('products', 'categories', 'tags'));
    }
}
