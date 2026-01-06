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
    public function index(Request $request)
    {
        $query = Transaction::with('items');

        // Status filter
        if ($request->filled('status')) {
            $query->where('status', $request->status);
        }

        // Search by invoice code or customer name
        if ($request->filled('search')) {
            $search = $request->search;
            $query->where(function($q) use ($search) {
                $q->where('invoice_code', 'LIKE', "%{$search}%")
                  ->orWhereRaw("JSON_EXTRACT(customer_info, '$.name') LIKE ?", ["%{$search}%"]);
            });
        }

        $transactions = $query->latest()->paginate(20)->withQueryString();

        // Get counts for each status
        $statusCounts = [
            'all' => Transaction::count(),
            'unpaid' => Transaction::where('status', 'unpaid')->count(),
            'paid' => Transaction::where('status', 'paid')->count(),
            'shipped' => Transaction::where('status', 'shipped')->count(),
            'completed' => Transaction::where('status', 'completed')->count(),
            'cancelled' => Transaction::where('status', 'cancelled')->count(),
        ];

        return view('admin.order.transaction.index', compact('transactions', 'statusCounts'));
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
