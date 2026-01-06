<?php

namespace App\Http\Controllers\Public;

use App\Http\Controllers\Controller;
use App\Models\Product;
use App\Models\Transaction;
use App\Models\TransactionItem;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Session;

class CheckoutController extends Controller
{
    /**
     * Display checkout form.
     */
    public function index()
    {
        $cart = Session::get('cart', []);

        if (empty($cart)) {
            return redirect()->route('cart.index')->with('error', 'Your cart is empty.');
        }

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

        return view('public.checkout.index', compact('cartItems', 'subtotal'));
    }

    /**
     * Process checkout and create transaction.
     */
    public function store(Request $request)
    {
        $cart = Session::get('cart', []);

        if (empty($cart)) {
            return redirect()->route('cart.index')->with('error', 'Your cart is empty.');
        }

        // Validate customer info
        $validated = $request->validate([
            'customer_name' => ['required', 'string', 'max:255'],
            'customer_whatsapp' => ['required', 'string', 'max:20'],
            'customer_address' => ['required', 'string'],
            'payment_method' => ['required', 'in:bank_transfer,cod'],
            'notes' => ['nullable', 'string'],
        ]);

        try {
            DB::beginTransaction();

            // Real-time stock validation
            $cartItems = [];
            $subtotal = 0;

            foreach ($cart as $productId => $item) {
                $product = Product::lockForUpdate()->find($productId);
                
                if (!$product || !$product->is_active) {
                    throw new \Exception("Product {$productId} is not available.");
                }

                if ($product->stock_control && $product->stock < $item['quantity']) {
                    throw new \Exception("Insufficient stock for {$product->name}. Only {$product->stock} available.");
                }

                $cartItems[] = [
                    'product' => $product,
                    'quantity' => $item['quantity'],
                    'price' => $product->price,
                    'subtotal' => $product->price * $item['quantity'],
                ];

                $subtotal += $product->price * $item['quantity'];
            }

            // Generate unique code (3 digits, 100-999)
            $uniqueCode = $this->generateUniqueCode($subtotal);
            
            // Calculate total
            $amountTotal = $subtotal + $uniqueCode;

            // Generate invoice code
            $invoiceCode = 'INV-' . now()->format('Ymd') . '-' . strtoupper(substr(md5(uniqid()), 0, 6));

            // Create transaction
            $transaction = Transaction::create([
                'invoice_code' => $invoiceCode,
                'customer_info' => [
                    'name' => $validated['customer_name'],
                    'whatsapp' => $validated['customer_whatsapp'],
                    'address' => $validated['customer_address'],
                ],
                'payment_method' => $validated['payment_method'],
                'unique_code' => $uniqueCode,
                'amount_subtotal' => $subtotal,
                'amount_total' => $amountTotal,
                'status' => 'unpaid',
                'notes' => $validated['notes'] ?? null,
            ]);

            // Create transaction items and update stock
            foreach ($cartItems as $item) {
                TransactionItem::create([
                    'transaction_id' => $transaction->id,
                    'product_id' => $item['product']->id,
                    'product_snapshot' => [
                        'name' => $item['product']->name,
                        'sku' => $item['product']->sku,
                    ],
                    'quantity' => $item['quantity'],
                    'price_locked' => $item['price'],
                    'subtotal' => $item['subtotal'],
                ]);

                // Deduct stock if stock control is enabled
                if ($item['product']->stock_control) {
                    $item['product']->decrement('stock', $item['quantity']);
                }
            }

            DB::commit();

            // Clear cart
            Session::forget('cart');

            return redirect()->route('invoice.show', $transaction)->with('success', 'Order placed successfully!');

        } catch (\Exception $e) {
            DB::rollBack();
            return back()->with('error', $e->getMessage())->withInput();
        }
    }

    /**
     * Generate unique 3-digit code that doesn't conflict with pending orders.
     */
    private function generateUniqueCode($subtotal)
    {
        // Get last 3 digits of subtotal
        $lastThreeDigits = (int) substr((string) $subtotal, -3);
        $uniqueCode = $lastThreeDigits;

        // Ensure it's within 100-999 range
        if ($uniqueCode < 100) {
            $uniqueCode += 100;
        } elseif ($uniqueCode > 999) {
            $uniqueCode = $uniqueCode % 900 + 100;
        }

        // Check for conflicts with pending orders
        $attempts = 0;
        while ($attempts < 100) {
            $conflict = Transaction::where('status', 'unpaid')
                ->where('unique_code', $uniqueCode)
                ->exists();

            if (!$conflict) {
                break;
            }

            // Generate new random code
            $uniqueCode = rand(100, 999);
            $attempts++;
        }

        return $uniqueCode;
    }
}
