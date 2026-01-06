<?php

namespace App\Http\Controllers\Public;

use App\Http\Controllers\Controller;
use App\Models\Product;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;

class CartController extends Controller
{
    /**
     * Display the shopping cart.
     */
    public function index()
    {
        $cart = Session::get('cart', []);
        $cartItems = [];
        $subtotal = 0;

        foreach ($cart as $productId => $item) {
            $product = Product::find($productId);
            
            if ($product) {
                $cartItems[] = [
                    'product' => $product,
                    'quantity' => $item['quantity'],
                    'subtotal' => $product->price * $item['quantity'],
                ];
                $subtotal += $product->price * $item['quantity'];
            }
        }

        return view('public.cart.index', compact('cartItems', 'subtotal'));
    }

    /**
     * Add product to cart.
     */
    public function add(Request $request, Product $product)
    {
        // Validate product is active and in stock
        if (!$product->is_active) {
            return back()->with('error', 'Product is not available.');
        }

        if ($product->stock_control && $product->stock < 1) {
            return back()->with('error', 'Product is out of stock.');
        }

        $validated = $request->validate([
            'quantity' => ['required', 'integer', 'min:1'],
        ]);

        $quantity = $validated['quantity'];

        // Check stock if stock control is enabled
        if ($product->stock_control && $quantity > $product->stock) {
            return back()->with('error', "Only {$product->stock} items available in stock.");
        }

        $cart = Session::get('cart', []);

        // Check if product already in cart
        if (isset($cart[$product->id])) {
            $newQuantity = $cart[$product->id]['quantity'] + $quantity;
            
            if ($product->stock_control && $newQuantity > $product->stock) {
                return back()->with('error', "Cannot add more. Only {$product->stock} items available.");
            }
            
            $cart[$product->id]['quantity'] = $newQuantity;
        } else {
            $cart[$product->id] = [
                'quantity' => $quantity,
                'added_at' => now()->toDateTimeString(),
            ];
        }

        Session::put('cart', $cart);

        return redirect()->route('cart.index')->with('success', 'Product added to cart.');
    }

    /**
     * Update cart item quantity.
     */
    public function update(Request $request, $productId)
    {
        $validated = $request->validate([
            'quantity' => ['required', 'integer', 'min:1'],
        ]);

        $product = Product::findOrFail($productId);
        $quantity = $validated['quantity'];

        // Check stock if stock control is enabled
        if ($product->stock_control && $quantity > $product->stock) {
            return back()->with('error', "Only {$product->stock} items available in stock.");
        }

        $cart = Session::get('cart', []);

        if (isset($cart[$productId])) {
            $cart[$productId]['quantity'] = $quantity;
            Session::put('cart', $cart);
            return back()->with('success', 'Cart updated.');
        }

        return back()->with('error', 'Product not found in cart.');
    }

    /**
     * Remove item from cart.
     */
    public function remove($productId)
    {
        $cart = Session::get('cart', []);

        if (isset($cart[$productId])) {
            unset($cart[$productId]);
            Session::put('cart', $cart);
            return back()->with('success', 'Product removed from cart.');
        }

        return back()->with('error', 'Product not found in cart.');
    }

    /**
     * Clear entire cart.
     */
    public function clear()
    {
        Session::forget('cart');
        return redirect()->route('cart.index')->with('success', 'Cart cleared.');
    }
}
