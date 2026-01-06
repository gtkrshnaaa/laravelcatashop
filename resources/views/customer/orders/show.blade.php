@extends('layouts.public')

@section('title', 'Order Detail - ' . $transaction->invoice_code)

@section('content')
    <div class="container mx-auto px-4 py-12">
        <div class="max-w-4xl mx-auto">
            <h1 class="text-4xl font-bold text-primary mb-2">Order Detail</h1>
            <p class="text-secondary mb-8">{{ $transaction->invoice_code }}</p>

            <div class="grid grid-cols-1 lg:grid-cols-3 gap-8">
                <div class="lg:col-span-2 space-y-6">
                    <!-- Items -->
                    <div class="bg-surface border border-border rounded-xl p-6">
                        <h2 class="font-bold text-primary mb-4">Order Items</h2>
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
                </div>

                <div class="lg:col-span-1">
                    <div class="bg-surface border border-border rounded-xl p-6 sticky top-20">
                        <h3 class="font-bold text-primary mb-4">Order Info</h3>
                        <div class="space-y-3 text-sm">
                            <div>
                                <p class="text-secondary">Status</p>
                                <p class="font-medium text-primary">{{ ucfirst($transaction->status) }}</p>
                            </div>
                            <div>
                                <p class="text-secondary">Payment Method</p>
                                <p class="font-medium text-primary">{{ ucfirst(str_replace('_', ' ', $transaction->payment_method)) }}</p>
                            </div>
                            <div>
                                <p class="text-secondary">Order Date</p>
                                <p class="font-medium text-primary">{{ $transaction->created_at->format('d M Y, H:i') }}</p>
                            </div>
                        </div>

                        <!-- Payment Proof Section -->
                        @if($transaction->payment_method === 'bank_transfer')
                            <div class="mt-6 pt-6 border-t border-border">
                                <h4 class="font-bold text-primary mb-2 text-sm">Payment Proof</h4>
                                
                                @if($transaction->payment_proof_path)
                                    <div class="mb-4">
                                        <p class="text-green-500 text-xs font-bold mb-2">✓ Proof Uploaded</p>
                                        <img src="{{ Storage::url($transaction->payment_proof_path) }}" alt="Payment Proof" class="w-full rounded-lg border border-border">
                                    </div>
                                @else
                                    <form action="{{ route('customer.orders.uploadProof', $transaction) }}" method="POST" enctype="multipart/form-data">
                                        @csrf
                                        <div class="mb-3">
                                            <input type="file" name="payment_proof" accept="image/*" class="w-full text-xs text-secondary file:mr-2 file:py-2 file:px-4 file:rounded-full file:border-0 file:text-xs file:font-semibold file:bg-primary/10 file:text-primary hover:file:bg-primary/20">
                                            @error('payment_proof')
                                                <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                                            @enderror
                                        </div>
                                        <button type="submit" class="w-full bg-primary text-background px-4 py-2 rounded-lg font-bold hover:opacity-90 transition-opacity text-sm">
                                            Upload Proof
                                        </button>
                                    </form>
                                @endif
                            </div>
                        @endif

                        <a href="{{ route('customer.orders.index') }}" class="block w-full text-center mt-4 text-secondary hover:text-primary transition-colors text-sm">
                            ← Back to Orders
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
