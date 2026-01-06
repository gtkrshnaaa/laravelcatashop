@extends('layouts.admin')

@section('title', 'Transaction Detail')

@section('content')
    <div class="max-w-4xl">
        <div class="mb-8">
            <h2 class="text-3xl font-bold text-primary mb-2">Transaction Detail</h2>
            <p class="text-secondary">{{ $transaction->invoice_code }}</p>
        </div>

        <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
            <!-- Transaction Info -->
            <div class="lg:col-span-2 space-y-6">
                <!-- Customer Info -->
                <div class="bg-surface border border-border rounded-xl p-6">
                    <h3 class="font-bold text-primary mb-4">Customer Information</h3>
                    <div class="space-y-2 text-sm">
                        <p><span class="text-secondary">Name:</span> <span class="text-primary font-medium">{{ $transaction->customer_info['name'] }}</span></p>
                        <p><span class="text-secondary">WhatsApp:</span> <span class="text-primary font-medium">{{ $transaction->customer_info['whatsapp'] }}</span></p>
                        <p><span class="text-secondary">Address:</span> <span class="text-primary">{{ $transaction->customer_info['address'] }}</span></p>
                    </div>
                </div>

                <!-- Order Items -->
                <div class="bg-surface border border-border rounded-xl p-6">
                    <h3 class="font-bold text-primary mb-4">Order Items</h3>
                    <div class="space-y-3">
                        @foreach($transaction->items as $item)
                            <div class="flex justify-between text-sm">
                                <div>
                                    <p class="font-medium text-primary">{{ $item->product_snapshot['name'] }}</p>
                                    <p class="text-xs text-secondary">{{ $item->quantity }} x Rp {{ number_format($item->price_locked, 0, ',', '.') }}</p>
                                </div>
                                <p class="font-mono text-primary">Rp {{ number_format($item->subtotal, 0, ',', '.') }}</p>
                            </div>
                        @endforeach
                    </div>

                    <div class="border-t border-border mt-4 pt-4 space-y-2">
                        <div class="flex justify-between text-sm text-secondary">
                            <span>Subtotal</span>
                            <span class="font-mono">Rp {{ number_format($transaction->amount_subtotal, 0, ',', '.') }}</span>
                        </div>
                        <div class="flex justify-between text-sm text-secondary">
                            <span>Unique Code</span>
                            <span class="font-mono text-green-400">+ {{ $transaction->unique_code }}</span>
                        </div>
                        <div class="flex justify-between text-lg font-bold text-primary">
                            <span>Total</span>
                            <span class="font-mono">Rp {{ number_format($transaction->amount_total, 0, ',', '.') }}</span>
                        </div>
                    </div>
                </div>

                <!-- Notes -->
                @if($transaction->notes)
                    <div class="bg-surface border border-border rounded-xl p-6">
                        <h3 class="font-bold text-primary mb-2">Order Notes</h3>
                        <p class="text-sm text-secondary">{{ $transaction->notes }}</p>
                    </div>
                @endif

                <!-- Payment Proof -->
                @if($transaction->payment_proof_path)
                    <div class="bg-surface border border-border rounded-xl p-6">
                        <h3 class="font-bold text-primary mb-4">Payment Proof</h3>
                        <a href="{{ Storage::url($transaction->payment_proof_path) }}" target="_blank" class="block">
                            <img src="{{ Storage::url($transaction->payment_proof_path) }}" alt="Payment Proof" class="w-full rounded-lg border border-border hover:opacity-90 transition-opacity">
                        </a>
                        <p class="text-xs text-secondary mt-2 text-center">Click image to view full size</p>
                    </div>
                @endif
            </div>

            <!-- Status & Actions -->
            <div class="lg:col-span-1">
                <div class="bg-surface border border-border rounded-xl p-6 sticky top-20">
                    <h3 class="font-bold text-primary mb-4">Transaction Status</h3>
                    
                    <div class="space-y-4">
                        <div>
                            <p class="text-xs text-secondary mb-1">Payment Method</p>
                            <p class="text-sm font-medium text-primary">{{ ucfirst(str_replace('_', ' ', $transaction->payment_method)) }}</p>
                        </div>

                        <div>
                            <p class="text-xs text-secondary mb-1">Created At</p>
                            <p class="text-sm font-medium text-primary">{{ $transaction->created_at->format('d M Y H:i') }}</p>
                        </div>

                        <div>
                            <p class="text-xs text-secondary mb-2">Current Status</p>
                            <form action="{{ route('admin.order.transactions.updateStatus', $transaction) }}" method="POST">
                                @csrf
                                @method('PATCH')
                                <select name="status" class="w-full bg-background border border-border rounded-lg px-4 py-2 text-primary mb-3">
                                    <option value="unpaid" {{ $transaction->status === 'unpaid' ? 'selected' : '' }}>Unpaid</option>
                                    <option value="paid" {{ $transaction->status === 'paid' ? 'selected' : '' }}>Paid</option>
                                    <option value="shipped" {{ $transaction->status === 'shipped' ? 'selected' : '' }}>Shipped</option>
                                    <option value="completed" {{ $transaction->status === 'completed' ? 'selected' : '' }}>Completed</option>
                                    <option value="cancelled" {{ $transaction->status === 'cancelled' ? 'selected' : '' }}>Cancelled</option>
                                </select>
                                <button type="submit" class="w-full bg-primary text-background px-4 py-2 rounded-lg font-bold hover:opacity-90 transition-opacity text-sm">
                                    Update Status
                                </button>
                            </form>
                        </div>

                        <a href="{{ route('admin.order.transactions.index') }}" class="block w-full text-center text-secondary hover:text-primary transition-colors text-sm mt-4">
                            Back to Transactions
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
