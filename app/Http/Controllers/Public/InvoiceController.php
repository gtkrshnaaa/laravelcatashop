<?php

namespace App\Http\Controllers\Public;

use App\Http\Controllers\Controller;
use App\Models\Transaction;

class InvoiceController extends Controller
{
    /**
     * Display invoice and payment instructions.
     */
    public function show(Transaction $transaction)
    {
        $transaction->load('items.product');

        return view('public.invoice.show', compact('transaction'));
    }
}
