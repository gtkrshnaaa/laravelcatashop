<?php

namespace App\Http\Controllers\Admin\Review;

use App\Http\Controllers\Controller;
use App\Models\ProductReview;
use Illuminate\Http\Request;

class ReviewModerationController extends Controller
{
    /**
     * Display all reviews for moderation.
     */
    public function index(Request $request)
    {
        $status = $request->get('status', 'pending');
        
        $reviews = ProductReview::with(['product', 'customer'])
            ->when($status !== 'all', function($query) use ($status) {
                $query->where('status', $status);
            })
            ->latest()
            ->paginate(20);

        return view('admin.review.index', compact('reviews', 'status'));
    }

    /**
     * Approve a review.
     */
    public function approve(ProductReview $review)
    {
        $review->update(['status' => 'approved']);
        return back()->with('success', 'Review approved successfully.');
    }

    /**
     * Reject a review.
     */
    public function reject(ProductReview $review)
    {
        $review->update(['status' => 'rejected']);
        return back()->with('success', 'Review rejected.');
    }

    /**
     * Delete a review.
     */
    public function destroy(ProductReview $review)
    {
        $review->delete();
        return back()->with('success', 'Review deleted successfully.');
    }
}
