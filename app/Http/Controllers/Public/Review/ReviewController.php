<?php

namespace App\Http\Controllers\Public\Review;

use App\Http\Controllers\Controller;
use App\Models\Product;
use App\Models\ProductReview;
use Illuminate\Http\Request;

class ReviewController extends Controller
{
    /**
     * Store a new review.
     */
    public function store(Request $request, Product $product)
    {
        $validated = $request->validate([
            'rating' => ['required', 'integer', 'min:1', 'max:5'],
            'review' => ['required', 'string', 'min:10', 'max:1000'],
            'images' => ['nullable', 'array', 'max:3'],
            'images.*' => ['image', 'max:2048'],
        ]);

        $reviewData = [
            'product_id' => $product->id,
            'rating' => $validated['rating'],
            'review' => $validated['review'],
            'status' => 'pending',
        ];

        // Handle customer or guest
        if (auth('customer')->check()) {
            $reviewData['customer_id'] = auth('customer')->id();
        } else {
            $reviewData['guest_name'] = $request->input('name', 'Anonymous');
        }

        // Handle images
        if ($request->hasFile('images')) {
            $imagePaths = [];
            foreach ($request->file('images') as $image) {
                $path = $image->store('reviews', 'public');
                $imagePaths[] = $path;
            }
            $reviewData['images'] = $imagePaths;
        }

        ProductReview::create($reviewData);

        return back()->with('success', 'Thank you for your review! It will be visible after admin approval.');
    }

    /**
     * Mark review as helpful.
     */
    public function markHelpful(ProductReview $review)
    {
        $review->increment('helpful_count');
        return back()->with('success', 'Thank you for your feedback!');
    }
}
