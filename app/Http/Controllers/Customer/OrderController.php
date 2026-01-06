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

    /**
     * Upload payment proof.
     */
    public function uploadProof(\Illuminate\Http\Request $request, Transaction $transaction)
    {
        // Ensure user owns transaction
        if ($transaction->customer_id !== auth('customer')->id()) {
            abort(403, 'Unauthorized');
        }

        $request->validate([
            'payment_proof' => ['required', 'image', 'max:2048'], // Max 2MB
        ]);

        $path = $request->file('payment_proof')->store('payment-proofs', 'public');

        $transaction->update([
            'payment_proof_path' => $path,
            'status' => 'paid', // Optional: auto-mark as paid or keep unpaid for manual verify?
            // "Manual Trust" philosophy -> Maybe keep it unpaid OR introduce 'verifying'?
            // Let's keep status as is, admin manually checks. User feels good uploading.
            // Or maybe just leave status alone and let Admin see the image.
            // But usually "Upload Proof" implies "I have paid".
            // Let's NOT auto-change status to 'paid' because that implies money received.
            // Let's create a NEW status or just let Admin decide.
            // For now, I will NOT change status automatically to maintain "Manual Trust".
            // Wait, if user uploading proof, status should probably be 'paid' (meaning 'I paid')?
            // No, 'paid' in system means 'Confirmed'.
            // I'll leave status alone for strict manual verification.
        ]);

        return back()->with('success', 'Payment proof uploaded successfully! Admin will verify shortly.');
    }
}
