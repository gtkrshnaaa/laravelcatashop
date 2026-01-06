<?php

namespace App\Http\Controllers\Customer;

use App\Http\Controllers\Controller;
use App\Models\Transaction;

class OrderController extends Controller
{
    /**
     * Display all customer orders.
     */
    public function index()
    {
        $orders = auth('customer')->user()->transactions()
            ->with('items.product')
            ->latest()
            ->paginate(15);

        return view('customer.orders.index', compact('orders'));
    }

    /**
     * Display specific order detail.
     */
    public function show(Transaction $transaction)
    {
        // Ensure customer can only view their own orders
        if ($transaction->customer_id !== auth('customer')->id()) {
            abort(403, 'Unauthorized access to this order.');
        }

        $transaction->load('items.product');

        return view('customer.orders.show', compact('transaction'));
    }
}
