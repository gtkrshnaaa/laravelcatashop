<?php

namespace App\Http\Controllers\Admin\Order;

use App\Http\Controllers\Controller;
use App\Models\Transaction;
use Illuminate\Http\Request;

class TransactionController extends Controller
{
    /**
     * Display a listing of transactions.
     */
    public function index()
    {
        $transactions = Transaction::with('items')
            ->latest()
            ->paginate(20);

        return view('admin.order.transaction.index', compact('transactions'));
    }

    /**
     * Display the specified transaction.
     */
    public function show(Transaction $transaction)
    {
        $transaction->load('items.product');

        return view('admin.order.transaction.show', compact('transaction'));
    }

    /**
     * Update transaction status.
     */
    public function updateStatus(Request $request, Transaction $transaction)
    {
        $validated = $request->validate([
            'status' => ['required', 'in:unpaid,paid,shipped,completed,cancelled'],
        ]);

        $transaction->changeStatus($validated['status']);

        return back()->with('success', 'Transaction status updated successfully.');
    }
}
