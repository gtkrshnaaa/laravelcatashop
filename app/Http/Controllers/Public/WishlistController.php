<?php

namespace App\Http\Controllers\Public;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Wishlist;

class WishlistController extends Controller
{
    /**
     * Toggle item in wishlist.
     */
    public function toggle(Request $request)
    {
        $request->validate([
            'product_id' => 'required|exists:products,id',
        ]);

        if (!auth('customer')->check()) {
            return response()->json(['status' => 'unauthenticated'], 401);
        }

        $user = auth('customer')->user();
        $productId = $request->product_id;

        // Check if exists
        $exists = $user->wishlists()->where('product_id', $productId)->exists();

        if ($exists) {
            $user->wishlists()->where('product_id', $productId)->delete();
            $status = 'removed';
        } else {
            $user->wishlists()->create(['product_id' => $productId]);
            $status = 'added';
        }

        return response()->json([
            'status' => $status,
            'message' => $status === 'added' ? 'Added to wishlist' : 'Removed from wishlist'
        ]);
    }
}
