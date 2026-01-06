<?php

namespace App\Http\Controllers\Public;

use App\Http\Controllers\Controller;
use App\Models\Product;

class ProductController extends Controller
{
    /**
     * Display the specified product.
     */
    public function show(Product $product)
    {
        // Check if product is active
        if (!$product->is_active) {
            abort(404);
        }

        // Load category and related products
        $product->load('category');
        
        $relatedProducts = Product::where('category_id', $product->category_id)
            ->where('id', '!=', $product->id)
            ->where('is_active', true)
            ->inStock()
            ->take(4)
            ->get();

        return view('public.product.show', compact('product', 'relatedProducts'));
    }
}
